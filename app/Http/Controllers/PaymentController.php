<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function checkout($id)
    {
        $reservation = Reservasi::with('kamar')->findOrFail($id);
        // Ensure a unique reservation code exists (for older reservations created before migration)
        if (! $reservation->reservation_code) {
            $reservation->reservation_code = 'RSV-' . Str::upper(Str::random(8));
            $reservation->save();
        }
        // Ensure a unique payment identifier exists so the checkout shows an alphanumeric code
        if (! $reservation->payment_id) {
            $reservation->payment_id = 'PAY-' . Str::upper(Str::random(10));
            $reservation->save();
        }
        return view('payment.checkout', compact('reservation'));
    }

    public function pay(Request $request, $id)
    {
        $reservation = Reservasi::findOrFail($id);
        $method = $request->input('payment_method', 'snap');
        $bank = $request->input('bank', 'bca');

        // Basic Midtrans keys sanity check to avoid calling SDK with placeholder values
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $clientKey = env('MIDTRANS_CLIENT_KEY');
        $midtransConfigured = ! empty($serverKey) && ! empty($clientKey) && stripos($serverKey, 'your_') === false && stripos($clientKey, 'your_') === false;
        if (! $midtransConfigured && (class_exists('Midtrans\\Snap') || class_exists('Midtrans\\Transaction')) ) {
            // If user tried to pay with Midtrans-enabled flow but keys are not set, return with user-friendly error
            return redirect()->route('payment.checkout', ['id' => $reservation->id])->withErrors(['midtrans' => 'Midtrans keys not configured. Set MIDTRANS_SERVER_KEY and MIDTRANS_CLIENT_KEY in your .env (sandbox keys for testing).']);
        }

        // If Midtrans PHP library is available and server key provided, use Snap
        if (class_exists('Midtrans\\Snap') && env('MIDTRANS_SERVER_KEY')) {
            try {
                \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
                \Midtrans\Config::$isSanitized = true;
                \Midtrans\Config::$is3ds = true;

                $orderId = 'ORDER-' . $reservation->id . '-' . time();
                // persist provider order id so it appears in payment summary
                $reservation->payment_id = $orderId;
                $reservation->save();
                $params = [
                    'transaction_details' => [
                        'order_id' => $orderId,
                        'gross_amount' => (int) $reservation->total_price,
                    ],
                    'customer_details' => [
                        'first_name' => $reservation->name ?? ($reservation->user->name ?? ''),
                        'email' => $reservation->email ?? ($reservation->user->email ?? ''),
                        'phone' => $reservation->phone ?? ($reservation->user->no_hp ?? ''),
                    ],
                    'item_details' => [[
                        'id' => $reservation->kamar_id,
                        'price' => (int) $reservation->total_price,
                        'quantity' => 1,
                        'name' => $reservation->kamar->name ?? 'Reservasi',
                    ]],
                ];

                // If bank transfer selected, create a direct charge to produce VA immediately
                if ($method === 'bank_transfer') {
                    try {
                        $chargeParams = $params;
                        // Midtrans expects payment_type and bank details for VA
                        $chargeParams['payment_type'] = 'bank_transfer';
                        // use selected bank from the request
                        $chargeParams['bank_transfer'] = ['bank' => $bank];

                        $chargeResponse = \Midtrans\Transaction::charge($chargeParams);
                        // Save provider order id if returned
                        if (! empty($chargeResponse->order_id)) {
                            $reservation->payment_id = $chargeResponse->order_id;
                            $reservation->save();
                        }

                        // If VA numbers returned, return VA details (JSON for AJAX or view for regular)
                        if (! empty($chargeResponse->va_numbers) || ! empty($chargeResponse->permata_va_number)) {
                            if ($request->ajax() || $request->wantsJson()) {
                                $chargeArray = json_decode(json_encode($chargeResponse), true);
                                return response()->json(['va' => $chargeArray, 'reservation' => $reservation]);
                            }
                            return view('payment.va', ['reservation' => $reservation, 'charge' => $chargeResponse]);
                        }

                        // fallback to Snap token if charge didn't yield VA
                    } catch (\Throwable $e) {
                        Log::error('Midtrans charge failed: ' . $e->getMessage());
                        // continue to Snap fallback
                    }
                }

                // Limit payment types for Snap if method is specific
                if ($method === 'bank_transfer') {
                    $params['enabled_payments'] = ['bank_transfer'];
                } elseif ($method === 'ewallet') {
                    $params['enabled_payments'] = ['gopay','shopeepay','qris'];
                }

                $snapToken = \Midtrans\Snap::getSnapToken($params);
                $clientKey = env('MIDTRANS_CLIENT_KEY');
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['snapToken' => $snapToken, 'clientKey' => $clientKey]);
                }
                return view('payment.snap', compact('reservation', 'snapToken', 'clientKey'));
            } catch (\Throwable $e) {
                Log::error('Midtrans Snap generation failed: ' . $e->getMessage());
                // fallback to mock gateway
                return redirect()->route('gateway.show', ['id' => $reservation->id, 'method' => $method])->withErrors(['payment' => 'Midtrans integration error, memakai simulator.']);
            }
        }

        // Fallback: use mock gateway simulator — generate mock payment id if not present
        if (! $reservation->payment_id) {
            $reservation->payment_id = 'MOCK-' . Str::upper(Str::random(10));
            $reservation->save();
        }
        return redirect()->route('gateway.show', ['id' => $reservation->id, 'method' => $method]);
    }

    /**
     * Endpoint for Midtrans server notification (IPN)
     */
    public function notification(Request $request)
    {
        if (! class_exists('Midtrans\\Notification')) {
            return response('Midtrans notification handler unavailable', 500);
        }

        try {
            \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            $notif = new \Midtrans\Notification();

            $orderId = $notif->order_id ?? null;
            $transactionStatus = $notif->transaction_status ?? null;
            $fraudStatus = $notif->fraud_status ?? null;

            // Extract local reservation id from order_id prefix
            if ($orderId && preg_match('/ORDER\-(\d+)\-/', $orderId, $m)) {
                $reservationId = (int) $m[1];
                $reservation = Reservasi::find($reservationId);
                if ($reservation) {
                    if ($transactionStatus === 'capture' || $transactionStatus === 'settlement') {
                        $reservation->status = 'paid';
                        $reservation->save();
                    } elseif (in_array($transactionStatus, ['deny','cancel','expire'])) {
                        $reservation->status = 'cancelled';
                        $reservation->save();
                    }
                }
            }

            return response('OK', 200);
        } catch (\Throwable $e) {
            Log::error('Midtrans notification error: ' . $e->getMessage());
            return response('ERROR', 500);
        }
    }
}
