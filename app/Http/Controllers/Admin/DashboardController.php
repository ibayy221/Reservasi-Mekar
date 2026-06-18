<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Kamar;
use App\Models\KamarAvailability;

class DashboardController extends Controller
{
    public function index()
    {
        $totalReservations = Reservasi::count();
        $recentReservations = Reservasi::with('kamar')->latest()->limit(10)->get();
        $roomsCount = Kamar::count();
        $roomsUnits = Kamar::sum('stock');
        // jumlah tersedia hari ini (fallback ke total units jika tidak ada data availability)
        $availableUnits = KamarAvailability::whereDate('date', now())->sum('available');
        if ($availableUnits <= 0) {
            $availableUnits = $roomsUnits;
        }
        return view('admin.dashboard', compact('totalReservations','recentReservations','roomsCount','roomsUnits','availableUnits'));
    }
}
