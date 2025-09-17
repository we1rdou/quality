<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rutas para autenticación con Google
Route::get('/auth/google', [App\Http\Controllers\SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [App\Http\Controllers\SocialAuthController::class, 'handleGoogleCallback']);

// Rutas para completar perfil (requiere autenticación pero no verificación)
Route::get('/profile/complete', App\Livewire\Profile\Complete::class)
    ->middleware(['auth'])
    ->name('profile.complete');

// Todas las rutas protegidas que requieren autenticación, verificación de email Y perfil completo
Route::middleware(['auth', 'verified', 'profile.complete', 'account.active'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rutas de configuración
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // Otras rutas protegidas...
});

// Rutas específicas para administradores
Route::middleware(['auth', 'verified', 'profile.complete', 'account.active', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard de administrador
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Gestión de usuarios
    Route::get('/users', \App\Livewire\Admin\Users::class)->name('users');

    // Estadísticas y reportes
    Volt::route('/reports', 'admin.reports')->name('reports');
});

require __DIR__.'/auth.php';
