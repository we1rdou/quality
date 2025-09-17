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
        
        if (session()->has('needs_profile_completion') || 
            ($user !== null && 
            (empty($user->phone) || empty($user->address) || empty($user->province) || empty($user->city)))) {
            return redirect()->route('profile.complete');
        }
        
        return $next($request);
    }
}
