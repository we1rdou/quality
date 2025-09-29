<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\WindowController;
use App\Http\Controllers\ProformaController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Ruta para la página de proformas
Route::get('/proforma', function () {
    return view('proforma');
})->name('proforma');

// Ruta para actualizar perfil desde el modal
Route::put('/perfil', [App\Http\Controllers\PerfilController::class, 'update'])->middleware('auth')->name('perfil.update');

// Ruta para cambio de contraseña desde el modal
Route::post('/perfil/password', [App\Http\Controllers\PasswordController::class, 'update'])->middleware('auth')->name('perfil.password');

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

    // Ruta para la galería extendida
    Route::get('/galeria', function () {
         return view('galeria');
    })->name('galeria');
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

// Rutas protegidas para listar y mostrar proformas del usuario autenticado
Route::middleware(['auth'])->group(function () {
    Route::get('/proformas', [ProformaController::class, 'index'])->name('proformas.index');
    Route::get('/proformas/{id}', [ProformaController::class, 'show'])->name('proformas.show');
});

// Rutas protegidas para crear, editar y eliminar ventanas
Route::middleware(['auth'])->group(function () {
    Route::get('/windows/create', [WindowController::class, 'create'])->name('windows.create');
    Route::post('/windows', [WindowController::class, 'store']);
    Route::get('/windows/{id}/edit', [WindowController::class, 'edit'])->name('windows.edit');
    Route::put('/windows/{id}', [WindowController::class, 'update'])->name('windows.update');
    Route::delete('/windows/{id}', [WindowController::class, 'destroy'])->name('windows.destroy');
});

// Ruta para la página de productos de Aluminio y Vidrio
Route::get('/productos/aluminio-vidrio', function () {
    return view('productos.aluminio_vidrio');
})->name('productos.aluminio_vidrio');

require __DIR__.'/auth.php';
