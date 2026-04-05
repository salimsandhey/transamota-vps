<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserTimezone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If user is authenticated and timezone is provided in request
        if (Auth::check() && $request->has('timezone')) {
            $user = Auth::user();
            // Update user's timezone if it's different
            if ($user->timezone !== $request->timezone) {
                $user->timezone = $request->timezone;
                $user->save();
            }
        }

        return $next($request);
    }
}