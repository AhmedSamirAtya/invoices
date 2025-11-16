<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Check if a user is logged in AND if their 'is_active' status is false
        if (Auth::check() && !Auth::user()->is_active) {

            // Log the user out immediately
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Redirect the user back to the login page with an error message
            return redirect('/login')->with('error', 'Your account is currently inactive. Please contact support.');
        }

        return $next($request);
    }
}
