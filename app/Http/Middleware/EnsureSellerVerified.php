<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSellerVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and is a seller
        if (auth()->check() && auth()->user()->role === 'seller') {
            // Don't redirect if already on the pending verification page
            if ($request->route()->getName() === 'seller.pending-verification') {
                // If seller is already verified, redirect them to dashboard
                if (auth()->user()->profile && 
                    auth()->user()->profile->verification_doc && 
                    auth()->user()->profile->verified_by_admin) {
                    return redirect()->route('seller.dashboard');
                }
                return $next($request);
            }
            
            // Don't redirect if accessing the documents upload page
            if (in_array($request->route()->getName(), ['seller.profile.documents', 'seller.profile.documents.upload', 'seller.profile.documents.delete'])) {
                return $next($request);
            }
            
            // Check if user has a profile
            if (!auth()->user()->profile) {
                return redirect()->route('seller.pending-verification');
            }
            
            // Check if user has uploaded verification document
            if (is_null(auth()->user()->profile->verification_doc)) {
                return redirect()->route('seller.pending-verification');
            }
            
            // Check if admin has verified the documents
            if (!auth()->user()->profile->verified_by_admin) {
                return redirect()->route('seller.pending-verification');
            }
        }

        return $next($request);
    }
}