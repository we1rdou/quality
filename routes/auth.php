<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\SocialAuthController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    Volt::route('login', 'auth.login')
        ->name('login');

    Volt::route('register', 'auth.register')
        ->name('register');

    Volt::route('forgot-password', 'auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'auth.reset-password')
        ->name('password.reset');

    // Añadir rutas de autenticación social
    Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])
        ->name('auth.google');
    Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
});

Route::middleware('auth')->group(function () {
    Volt::route('verify-email', 'auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'auth.confirm-password')
        ->name('password.confirm');
        
    // Añadir ruta para completar perfil
    Volt::route('profile/complete', 'auth.complete-profile')
        ->name('profile.complete');
});

Route::post('logout', App\Livewire\Actions\Logout::class)
    ->name('logout');
