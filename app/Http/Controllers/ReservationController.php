<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'kamar_id' => 'required|exists:kamar,id',
            'checkin' => 'required|date',
            'checkout' => 'required|date|after:checkin',
            'adults' => 'sometimes|integer|min:1',
            'children' => 'sometimes|integer|min:0',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'smoking_preference' => 'nullable|in:non-smoking,smoking',
            'bed_setup' => 'nullable|in:large,twin',
            'special_requests' => 'nullable|string|max:1000',
        ]);

        $kamar = Kamar::findOrFail($data['kamar_id']);

        $nights = (new \DateTime($data['checkin']))->diff(new \DateTime($data['checkout']))->days;

        // wrap in transaction and re-check availability
        try {
            $reservation = DB::transaction(function () use ($data, $kamar, $nights) {
                $reservedCount = Reservasi::where('kamar_id', $kamar->id)
                    ->where(function ($q) use ($data) {
                        $q->where('check_in', '<', $data['checkout'])
                          ->where('check_out', '>', $data['checkin']);
                    })->count();

                $available = max(0, $kamar->stock - $reservedCount);
                if ($available <= 0) {
                    return null; // indicate not available
                }

                $total = $kamar->price * $nights;

                // generate unique reservation code
                $code = null;
                $tries = 0;
                do {
                    $code = 'RSV-' . Str::upper(Str::random(8));
                    $exists = Reservasi::where('reservation_code', $code)->exists();
                    $tries++;
                } while ($exists && $tries < 5);

                $res = Reservasi::create([
                    'user_id' => auth()->id(),
                    'kamar_id' => $kamar->id,
                    'reservation_code' => $code,
                    'check_in' => $data['checkin'],
                    'check_out' => $data['checkout'],
                    'nights' => $nights,
                        'adults' => $data['adults'] ?? 1,
                        'children' => $data['children'] ?? 0,
                    'total_price' => $total,
                    'status' => 'booked',
                    'smoking_preference' => $data['smoking_preference'] ?? null,
                    'bed_setup' => $data['bed_setup'] ?? null,
                    'special_requests' => $data['special_requests'] ?? null,
                ]);

                return $res;
            });

            if (! $reservation) {
                return back()->withErrors(['availability' => 'Kamar tidak tersedia untuk tanggal yang Anda pilih.'])->withInput();
            }

            return redirect()->route('payment.checkout', ['id' => $reservation->id]);
        } catch (\Throwable $e) {
            // Log and return friendly error
            report($e);
            return back()->withErrors(['reservation' => 'Terjadi kesalahan saat memproses reservasi. Silakan coba lagi.'])->withInput();
        }
    }

    public function show($id)
    {
        $reservation = Reservasi::with('kamar')->findOrFail($id);
        return view('reservation_success', compact('reservation'));
    }
}
