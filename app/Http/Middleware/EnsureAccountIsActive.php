<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAccountIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Check if account is suspended
            if ($user->isSuspended()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $until = $user->suspended_until ? $user->suspended_until->format('d/m/Y H:i') : 'indefinidamente';

                return redirect()->route('login')->with('error',
                    'Su cuenta ha sido suspendida hasta '.$until.'. Razón: '.
                    ($user->suspension_reason ?? 'Suspensión temporal por incumplimiento.')
                );
            }
        }

        return $next($request);
    }
}
