<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleLoginController extends Controller
{
    /**
     * 1. Hantar pengguna ke halaman log masuk rasmi Google
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * 2. Terima data daripada Google selepas pengguna berjaya login
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Cari pengguna berdasarkan e-mel Google dalam database Supabase
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Daftar secara automatik jika kali pertama log masuk
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(Str::random(16)), 
                ]);
            }

            // Log masuk pengguna dan aktifkan "Remember Me" automatik
            Auth::login($user, true);

            return redirect('/user')->with('success', 'Selamat Datang! Anda telah berjaya log masuk menggunakan akaun Google.');

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Log masuk Google gagal atau dibatalkan.');
        }
    }
}