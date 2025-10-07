<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();

                // ✅ If admin user
                if ($user->is_admin) {
                    return redirect()->route('dashboard');
                }

                // ✅ If normal user with verified email
                if ($user->hasVerifiedEmail()) {
                    return redirect()->route('dashboard');
                }

                // ✅ If user email not verified
                return redirect()->route('verification.notice');
            }
        }

        // ✅ Continue request for guest users
        return $next($request);
    }
}
