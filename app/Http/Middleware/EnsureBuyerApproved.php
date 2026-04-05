<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureBuyerApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and is a buyer
        if (auth()->check() && auth()->user()->role === 'buyer') {
            // Don't redirect if already on the pending approval page
            if ($request->route()->getName() === 'buyer.pending-approval') {
                // If buyer is already approved, redirect them to dashboard
                if (auth()->user()->is_verified) {
                    return redirect()->route('buyer.dashboard');
                }
                return $next($request);
            }
            
            // Check if admin has approved the buyer
            if (!auth()->user()->is_verified) {
                return redirect()->route('buyer.pending-approval');
            }
        }

        return $next($request);
    }
}