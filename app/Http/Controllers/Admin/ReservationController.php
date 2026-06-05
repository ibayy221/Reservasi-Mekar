<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservasi;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservasi::with('kamar','user')->latest()->paginate(20);
        return view('admin.reservations.index', compact('reservations'));
    }

    public function show($id)
    {
        $reservation = Reservasi::with('kamar','user')->findOrFail($id);
        return view('admin.reservations.show', compact('reservation'));
    }

    public function updateStatus(Request $request, $id)
    {
        $reservation = Reservasi::findOrFail($id);
        $data = $request->validate(['status' => 'required|in:booked,paid,cancelled']);
        $reservation->status = $data['status'];
        $reservation->save();
        return back()->with('status','Status reservasi diperbarui.');
    }
}
