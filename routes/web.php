<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Middleware\EnsureProfileIsComplete;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Actualizar esta ruta para incluir el middleware de perfil completo directamente
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', EnsureProfileIsComplete::class])
    ->name('dashboard');

// Otras rutas protegidas también con el middleware de perfil completo
Route::middleware(['auth', EnsureProfileIsComplete::class])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
