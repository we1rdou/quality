<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Verificar si hay token
            $token = JWTAuth::getToken();
            if (!$token) {
                return $this->unauthorized();
            }

            // Validar token y obtener usuario
            $user = JWTAuth::authenticate($token);
            if (!$user) {
                return $this->unauthorized();
            }

            // Obtener claims del token
            $payload = JWTAuth::getPayload($token);
            $tokenSessionId = $payload->get('session_id');
            
            // Verificar si la sesión sigue siendo válida (sesión única)
            if ($user->current_session_id && $user->current_session_id !== $tokenSessionId) {
                return response()->json([
                    'error' => 'Sesión inválida. Has iniciado sesión en otro dispositivo.',
                    'force_logout' => true
                ], 401);
            }

        } catch (TokenExpiredException $e) {
            return response()->json([
                'error' => 'Token expirado',
                'force_logout' => true
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'error' => 'Token inválido',
                'force_logout' => true
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Token ausente',
                'force_logout' => true
            ], 401);
        }

        return $next($request);
    }

    private function unauthorized()
    {
        return response()->json([
            'error' => 'No autorizado',
            'force_logout' => true
        ], 401);
    }
}
