<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // ✅ If not logged in, redirect to login page
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors([
                'error' => 'You must be logged in to access this page.',
            ]);
        }

        return $next($request);
    }
}
