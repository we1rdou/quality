<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class SocialAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Buscar usuario
            $user = User::where('email', $googleUser->email)->first();
            
            if (!$user) {
                // Crear nuevo usuario
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => bcrypt(Str::random(16)),
                    'email_verified_at' => now(),
                    'oauth_provider' => 'google', // Guardar el proveedor
                ]);
                
                session(['needs_profile_completion' => true]);
            }
            
            // Verificar si faltan campos del perfil
            if (empty($user->address) || empty($user->phone) || empty($user->province) || empty($user->city)) {
                session(['needs_profile_completion' => true]);
            }
            
            // Iniciar sesión
            Auth::login($user, true); // El segundo parámetro true es para "remember me"
            
            // Limpia cualquier caché de sesión anterior
            Session::regenerate();
            
            // Logging para debug
            Log::info('Usuario autenticado con Google: ' . $user->email);
            Log::info('Needs profile completion: ' . (session('needs_profile_completion') ? 'Yes' : 'No'));
            
            // Redirigir según estado
            if (session('needs_profile_completion')) {
                return redirect()->route('profile.complete');
            }
            
            return redirect()->intended('dashboard');
            
        } catch (\Exception $e) {
            Log::error('Error en autenticación Google: ' . $e->getMessage());
            return redirect('/login')->withErrors(['error' => 'Error al autenticar con Google: ' . $e->getMessage()]);
        }
    }
}
