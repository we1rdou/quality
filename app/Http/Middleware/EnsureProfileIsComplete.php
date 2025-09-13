<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileIsComplete
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        if ($user && (empty($user->address) || empty($user->phone) || empty($user->province) || empty($user->city))) {
            // Guardar la URL a la que intentaba acceder
            if (!$request->is('profile/complete') && !$request->is('logout')) {
                session(['url.intended' => $request->url()]);
            }
            
            return redirect()->route('profile.complete');
        }
        
        return $next($request);
    }
}
