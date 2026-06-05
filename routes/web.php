<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\AvailabilityController;

Route::get('/', function () {
    return view('landing');
});
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Handle login form submission (simple local auth)
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();
        $user = Auth::user();
        if ($user && ($user->role === 'admin' || $user->role === 'receptionist')) {
            return redirect()->intended('/admin');
        }
        return redirect()->intended('/');
    }

    return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Handle registration form submission
Route::post('/register', function (Request $request) {
    $data = $request->validate([
        'nama_lengkap' => 'required|string|max:255',
        'nik_ktp' => 'required|string|max:255',
        'no_hp' => 'required|string|max:50',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|string|min:8',
    ]);

    $user = User::create([
        'name' => $data['nama_lengkap'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'no_hp' => $data['no_hp'] ?? null,
        'nik_ktp' => $data['nik_ktp'] ?? null,
    ]);

    Auth::login($user);

    return redirect()->intended('/booking');
})->name('register');

Route::get('/kamar', function () {
    return view('kamar');
})->name('kamar');

// Availability API (used by frontend search)
Route::get('/api/availability', [AvailabilityController::class, 'index']);

// Booking page
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MockGatewayController;
use App\Http\Controllers\Admin\KamarController as AdminKamarController;
use App\Http\Controllers\Auth\SocialAuthController;

Route::get('/booking', [BookingController::class, 'create'])->name('booking.create')->middleware('auth');
// Socialite Google OAuth routes
Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

// Debug route: return the actual Google OAuth URL (local only)
Route::get('auth/google/debug', function () {
    if (!app()->environment('local')) {
        abort(403);
    }
    try {
        $url = \Laravel\Socialite\Facades\Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
        return response()->json(['url' => $url]);
    } catch (\Throwable $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});
Route::post('/reservasi', [ReservationController::class, 'store'])->name('reservation.store');
Route::get('/reservasi/{id}', [ReservationController::class, 'show'])->name('reservation.show');

// Profile edit for authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Logout route
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Payment routes
Route::get('/payment/{id}', [PaymentController::class, 'checkout'])->name('payment.checkout')->middleware('auth');
Route::post('/payment/{id}/pay', [PaymentController::class, 'pay'])->name('payment.pay')->middleware('auth');

// Mock Gateway simulation routes (demo)
Route::get('/gateway/{id}', [MockGatewayController::class, 'show'])->name('gateway.show')->middleware('auth');
Route::post('/gateway/{id}/callback', [MockGatewayController::class, 'callback'])->name('gateway.callback')->middleware('auth');

// Midtrans notification (server-to-server) endpoint (sandbox)
Route::post('/midtrans/notification', [PaymentController::class, 'notification'])->name('midtrans.notification');

// Admin routes (basic)
use App\Http\Middleware\EnsureAdminOrReceptionist;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;

Route::prefix('admin')->name('admin.')->middleware(['auth', EnsureAdminOrReceptionist::class])->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/kamar', [AdminKamarController::class, 'index'])->name('kamar.index');
    Route::get('/kamar/{id}/edit', [AdminKamarController::class, 'edit'])->name('kamar.edit');
    Route::put('/kamar/{id}', [AdminKamarController::class, 'update'])->name('kamar.update');

    Route::get('/reservations', [AdminReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/{id}', [AdminReservationController::class, 'show'])->name('reservations.show');
    Route::post('/reservations/{id}/status', [AdminReservationController::class, 'updateStatus'])->name('reservations.updateStatus');
});

// DEV: temporary helper to update current user's KTP / phone via query string
// Usage (while logged in): /dev/update-me?nik=1234567890123456&phone=0812xxxx
// Remove this route after updating for security.
use Illuminate\Http\Request as HttpRequest;
Route::get('/dev/update-me', function (HttpRequest $request) {
    $user = auth()->user();
    if (! $user) {
        abort(403);
    }
    $updated = false;
    if ($request->filled('nik')) {
        $user->nik_ktp = $request->query('nik');
        $updated = true;
    }
    if ($request->filled('phone')) {
        $user->no_hp = $request->query('phone');
        $updated = true;
    }
    if ($updated) {
        $user->save();
        return response('User updated', 200);
    }
    return response('No params provided', 400);
})->middleware('auth');