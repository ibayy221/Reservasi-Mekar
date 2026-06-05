<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AvailabilityController extends Controller
{
    /**
     * GET /api/availability
     * Params: checkin, checkout, adults, children
     */
    public function index(Request $request)
    {
        $data = $request->validate([
            'checkin' => 'required|date',
            'checkout' => 'required|date|after:checkin',
            'adults' => 'sometimes|integer|min:1',
            'children' => 'sometimes|integer|min:0',
        ]);

        $checkin = $data['checkin'];
        $checkout = $data['checkout'];
        $adults = $data['adults'] ?? 1;
        $children = $data['children'] ?? 0;
        $neededGuests = $adults + $children;

        $nights = (new \DateTime($checkin))->diff(new \DateTime($checkout))->days;

        try {
            // consider per-date overrides from kamar_availabilities
            $start = new \DateTime($checkin);
            $end = new \DateTime($checkout);
            $period = new \DatePeriod($start, new \DateInterval('P1D'), $end);

            $endDate = (new \DateTime($checkout))->modify('-1 day')->format('Y-m-d');
            $overrides = \App\Models\KamarAvailability::whereBetween('date', [$checkin, $endDate])->get();

            $rooms = Kamar::all()->map(function ($kamar) use ($checkin, $checkout, $neededGuests, $nights, $period, $overrides) {
                if ($kamar->capacity < $neededGuests) {
                    return null;
                }

                $reserved = Reservasi::where('kamar_id', $kamar->id)
                    ->where(function ($q) use ($checkin, $checkout) {
                        $q->where('check_in', '<', $checkout)
                          ->where('check_out', '>', $checkin);
                    })
                    ->count();

                // determine min stock for date range (respect overrides)
                $minStock = $kamar->stock;
                try {
                    foreach ($period as $d) {
                        $date = $d->format('Y-m-d');
                        $ov = $overrides->first(function($item) use ($kamar, $date) {
                            return $item->kamar_id == $kamar->id && $item->date == $date;
                        });
                        if ($ov) {
                            $minStock = min($minStock, $ov->available);
                        }
                    }
                } catch (\Exception $e) {
                    // ignore, fallback to default stock
                }

                $available = max(0, $minStock - $reserved);

                return [
                    'id' => $kamar->id,
                    'name' => $kamar->name,
                    'slug' => $kamar->slug,
                    'description' => $kamar->description,
                    'price' => $kamar->price,
                    'capacity' => $kamar->capacity,
                    'stock' => $kamar->stock,
                    'available' => $available,
                    'nights' => $nights,
                    'total_price' => $kamar->price * $nights,
                    'image' => $kamar->image,
                    'images' => $kamar->image ? [$kamar->image] : [],
                ];
            })->filter()->values();

        } catch (\Exception $e) {
            // Likely migrations not run or DB error; log and return empty rooms array so frontend can handle gracefully
            Log::error('Availability API error: ' . $e->getMessage());
            return response()->json([
                'checkin' => $checkin,
                'checkout' => $checkout,
                'nights' => $nights,
                'rooms' => [],
            ]);
        }

        // Only return rooms with available > 0
        $rooms = $rooms->filter(function ($r) {
            return $r['available'] > 0;
        })->values();

        $total_available = $rooms->sum(function($r){ return $r['available']; });
        $hotel_total = 231; // total rooms in Mercure

        return response()->json([
            'checkin' => $checkin,
            'checkout' => $checkout,
            'nights' => $nights,
            'rooms' => $rooms,
            'total_available' => $total_available,
            'hotel_total' => $hotel_total,
        ]);
    }
}
