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
        $defaultRoute = route('home');

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended($defaultRoute);
        }

        $request->fulfill();

        return redirect()->intended($defaultRoute);
    }

    /**
     * Send the email verification notification.
     */
    public function send(): RedirectResponse
    {
        $user = request()->user();
        if ($user->hasVerifiedEmail()) {
            return back()->with('resent', true);
        }
        $user->sendEmailVerificationNotification();
        return back()->with('resent', true);
    }
}
