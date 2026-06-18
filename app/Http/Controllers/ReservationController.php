<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Reservasi;
use App\Models\KamarAvailability;
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

        // wrap in transaction and re-check per-date availability
        try {
            $reservation = DB::transaction(function () use ($data, $kamar, $nights) {
                $checkin = \Carbon\Carbon::parse($data['checkin']);
                $checkout = \Carbon\Carbon::parse($data['checkout']);

                // Build date range (each night booked)
                $dates = [];
                for ($dt = $checkin->copy(); $dt->lt($checkout); $dt->addDay()) {
                    $dates[] = $dt->toDateString();
                }

                // Verify availability for each date
                foreach ($dates as $date) {
                    $avail = KamarAvailability::firstOrCreate(
                        ['kamar_id' => $kamar->id, 'date' => $date],
                        ['available' => $kamar->stock]
                    );

                    if ($avail->available <= 0) {
                        return null; // not available on at least one date
                    }
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

                // decrement availability for each booked date
                foreach ($dates as $date) {
                    $avail = KamarAvailability::where('kamar_id', $kamar->id)->where('date', $date)->lockForUpdate()->first();
                    if ($avail) {
                        $avail->available = max(0, $avail->available - 1);
                        $avail->save();
                    }
                }

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

    /**
     * Show list of reservations for the authenticated user
     */
    public function index()
    {
        $user = auth()->user();
        $reservations = Reservasi::with('kamar')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('reservations.index', compact('reservations'));
    }
}
