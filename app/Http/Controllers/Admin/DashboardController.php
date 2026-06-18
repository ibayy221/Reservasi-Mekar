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
        // total reservasi (semua, kecuali yang dibatalkan)
        $totalReservations = Reservasi::where('status', '!=', 'cancelled')->count();
        $recentReservations = Reservasi::with('kamar')->latest()->limit(10)->get();
        $roomsCount = Kamar::count();
        $roomsUnits = Kamar::sum('stock');
        // jumlah tersedia hari ini: hitung dari total unit dikurangi reservasi aktif hari ini
        // Hitung jumlah reservasi yang sebenarnya menginap/overlap hari ini
        $today = now();
        $reservedToday = Reservasi::where('status', '!=', 'cancelled')
            ->whereDate('check_in', '<=', $today)
            ->whereDate('check_out', '>', $today)
            ->count();

        $availableUnits = max(0, $roomsUnits - $reservedToday);
        return view('admin.dashboard', compact('totalReservations','recentReservations','roomsCount','roomsUnits','availableUnits'));
    }
}
