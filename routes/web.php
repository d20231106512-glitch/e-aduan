<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ComplaintController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\AuthController;

// Root redirect
Route::get('/', function () {
    return redirect()->route('admin.login');
});

// Guest Admin Routes
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Protected Admin Portal Group
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings/contacts', [SettingController::class, 'storeContact'])->name('settings.storeContact');
    Route::delete('/settings/contacts/{id}', [SettingController::class, 'destroyContact'])->name('settings.destroyContact');
    Route::delete('/settings/users/{id}', [SettingController::class, 'deleteUser'])->name('settings.deleteUser');

    // Complaints
    Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/{id}', [ComplaintController::class, 'show'])->name('complaints.show');
    Route::put('/complaints/{id}/status', [ComplaintController::class, 'updateStatus'])->name('complaints.updateStatus');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});
