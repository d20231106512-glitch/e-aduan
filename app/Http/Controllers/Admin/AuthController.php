<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // 1. Paparkan borang log masuk tersuai
    public function showLoginForm()
    {
        if (session()->has('admin_authenticated')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    // 2. Sahkan kelayakan log masuk tetap
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // KELAYAKAN TETAP (HARDCODED) UNTUK PORTAL PENTADBIR
        $fixedUsername = 'admin';
        $fixedPassword = 'password123';

        if ($request->username === $fixedUsername && $request->password === $fixedPassword) {
            // Simpan penanda sesi selamat yang menunjukkan pentadbir telah disahkan
            session(['admin_authenticated' => true]);

            // 🌟 KEMAS KINI: Tambah ->with('show_tour', true) untuk cetus onboarding tour sekali sahaja selepas login
            return redirect()->route('admin.dashboard')
                ->with('success', 'Selamat kembali, Pentadbir!')
                ->with('show_tour', true);
        }

        return redirect()->back()
            ->withInput($request->only('username'))
            ->with('error', 'Nama pengguna atau kata laluan tidak sah.');
    }

    // 3. Kosongkan sesi semasa log keluar
    public function logout()
    {
        session()->forget('admin_authenticated');
        return redirect()->route('admin.login')->with('success', 'Berjaya log keluar dari sistem.');
    }
}
