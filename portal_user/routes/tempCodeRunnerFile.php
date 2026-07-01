<?php

use App\Http\Controllers\Admin\SettingController;

Route::prefix('admin')->name('admin.')->group(function () {
    // Settings Page View
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');

    // Security Contacts Actions
    Route::post('/settings/contacts', [SettingController::class, 'storeContact'])->name('settings.storeContact');
    Route::delete('/settings/contacts/{id}', [SettingController::class, 'destroyContact'])->name('settings.destroyContact');

    // User Management Actions
    Route::delete('/settings/users/{id}', [SettingController::class, 'deleteUser'])->name('settings.deleteUser');
});

require __DIR__.'/auth.php';