<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Kamar;

class DashboardController extends Controller
{
    public function index()
    {
        $totalReservations = Reservasi::count();
        $recentReservations = Reservasi::with('kamar')->latest()->limit(10)->get();
        $roomsCount = Kamar::count();
        return view('admin.dashboard', compact('totalReservations','recentReservations','roomsCount'));
    }
}
