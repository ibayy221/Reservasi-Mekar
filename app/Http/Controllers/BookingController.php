<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create(Request $request)
    {
        $kamar_id = $request->query('kamar_id');
        $checkin = $request->query('checkin');
        $checkout = $request->query('checkout');
        $adults = $request->query('adults', 2);
        $children = $request->query('children', 0);

        $kamar = null;
        if ($kamar_id) {
            $kamar = Kamar::find($kamar_id);
        }

        return view('booking', compact('kamar', 'checkin', 'checkout', 'adults', 'children'));
    }
}
