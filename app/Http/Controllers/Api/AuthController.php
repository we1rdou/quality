<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Login de usuario con JWT
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Datos inválidos',
                'messages' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'error' => 'Credenciales incorrectas'
            ], 401);
        }

        $user = Auth::user();
        
        // Generar session_id único para invalidar sesiones anteriores
        $sessionId = uniqid();
        
        // Actualizar session_id en la base de datos
        $user->update(['current_session_id' => $sessionId]);

        // Crear token con claims personalizados
        $token = JWTAuth::fromUser($user, [
            'session_id' => $sessionId,
            'email' => $user->email,
            'name' => $user->name,
        ]);

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
            ],
            'session_id' => $sessionId,
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }

    /**
     * Logout de usuario
     */
    public function logout(Request $request)
    {
        try {
            $user = JWTAuth::authenticate();
            if ($user) {
                // Limpiar session_id para invalidar el token
                $user->update(['current_session_id' => null]);
            }
            
            JWTAuth::invalidate(JWTAuth::getToken());
            
            return response()->json([
                'message' => 'Logout exitoso'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al hacer logout'
            ], 500);
        }
    }

    /**
     * Obtener información del usuario autenticado
     */
    public function me()
    {
        try {
            $user = JWTAuth::authenticate();
            
            if (!$user) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }

            return response()->json([
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified_at' => $user->email_verified_at,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Token inválido'], 401);
        }
    }

    /**
     * Refrescar token
     */
    public function refresh()
    {
        try {
            $token = JWTAuth::refresh(JWTAuth::getToken());
            $user = JWTAuth::authenticate($token);
            
            return response()->json([
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified_at' => $user->email_verified_at,
                ],
                'expires_in' => JWTAuth::factory()->getTTL() * 60
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo refrescar el token'], 401);
        }
    }
}
