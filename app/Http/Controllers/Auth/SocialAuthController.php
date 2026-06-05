<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToGoogle()
    {
        // Guard: if client_id not configured, show friendly message instead of sending malformed request to Google
        $clientId = config('services.google.client_id');
        if (empty($clientId)) {
            return redirect()->route('login')->with('error', 'Google OAuth belum dikonfigurasi. Isi GOOGLE_CLIENT_ID/GOOGLE_CLIENT_SECRET/GOOGLE_REDIRECT di .env.');
        }

        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        $socialUser = Socialite::driver('google')->stateless()->user();

        if (! $socialUser || ! $socialUser->getEmail()) {
            return redirect()->route('login')->with('error', 'Tidak dapat mengambil data dari Google.');
        }

        $user = User::updateOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? $socialUser->getEmail(),
                'email_verified_at' => now(),
                'password' => null,
            ]
        );

        Auth::login($user, true);

        return redirect()->intended('/booking');
    }
}
