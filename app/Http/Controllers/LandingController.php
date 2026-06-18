<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Kamar;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('order')->get();
        $kamars = Kamar::all();
        return view('landing', compact('events', 'kamars'));
    }
}
