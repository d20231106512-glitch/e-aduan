<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller - Versi Sempurna & Kalis Ralat showLoginForm
    |--------------------------------------------------------------------------
    */

    /**
     * FUNGSI BARU: Memaparkan Halaman / Borang Login Kepada Pengguna
     */
    public function showLoginForm()
    {
        // Menyuruh Laravel membuka fail resources/views/auth/login.blade.php
        return view('auth.login');
    }

    /**
     * FUNGSI LOGOUT (Manual & Selamat)
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah berjaya log keluar daripada sistem.');
    }

    /**
     * ==========================================
     * LOG MASUK GOOGLE (SOCIALITE API)
     * ==========================================
     */

    /**
     * 1. Menghantar pengguna ke halaman log masuk rasmi Google API
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * 2. Menerima maklumat respon daripada Google selepas pengguna selesai log masuk
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Semak e-mel Google dalam table 'users' Supabase
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Daftar automatik jika pengguna pertama kali masuk
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(Str::random(16)), 
                ]);
            }

            // LOGIN & AKTIFKAN "REMEMBER ME" AUTOMATIK
            Auth::login($user, true);

            return redirect('/user')->with('success', 'Selamat Datang! Anda telah berjaya log masuk menggunakan akaun Google.');

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Log masuk menggunakan akaun Google gagal atau dibatalkan. Sila cuba lagi.');
        }
    }
}