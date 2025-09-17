<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();
        $defaultRoute = $user->isAdmin() ? route('admin.dashboard', absolute: false) : route('dashboard', absolute: false);

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended($defaultRoute.'?verified=1');
        }

        $request->fulfill();

        return redirect()->intended($defaultRoute.'?verified=1');
    }
}
