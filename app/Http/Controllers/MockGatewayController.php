<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MockGatewayController extends Controller
{
    // Shows a fake payment gateway page where user can simulate success/failure
    public function show(Request $request, $id)
    {
        $reservation = Reservasi::with('kamar')->findOrFail($id);
        $method = $request->query('method', 'bank_transfer');
        if (! $reservation->payment_id) {
            $reservation->payment_id = 'MOCK-' . Str::upper(Str::random(10));
            $reservation->save();
        }
        return view('gateway.simulate', compact('reservation', 'method'));
    }

    // Callback endpoint to receive simulated gateway result
    public function callback(Request $request, $id)
    {
        $reservation = Reservasi::findOrFail($id);
        $status = $request->input('status', 'success');

        if ($status === 'success') {
            $reservation->status = 'paid';
            $reservation->save();
            return redirect()->route('reservation.show', ['id' => $reservation->id])->with('status', 'Pembayaran berhasil (simulasi).');
        }

        return redirect()->route('payment.checkout', ['id' => $reservation->id])->withErrors(['payment' => 'Pembayaran gagal (simulasi). Silakan coba lagi.']);
    }
}
