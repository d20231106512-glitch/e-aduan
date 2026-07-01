<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () { return view('welcome'); });


// Pull in authentication routes (login/register/forgot-password/reset/logout/etc.)
require __DIR__.'/auth.php';

use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ProfileController;

// --- PORTAL (Perlukan Login) ---
Route::middleware(['auth'])->group(function () {
    // OLD interface (white background + logo + icons) => dashboard.blade.php
    Route::get('/user', function () { return view('dashboard'); })->name('user.index');

    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

    // Complaints
    Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
    Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});
