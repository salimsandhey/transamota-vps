<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class VerifyEmailController extends Controller
{
    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function notice(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        // Check if user has already verified their email
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended('/');
        }
        
        // Return the verification page without sending email
        return view('auth.verify-email');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  string  $hash
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(Request $request, $id, $hash)
    {
        // Find the user by ID
        $user = \App\Models\User::find($id);
        
        // Check if user exists
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => [trans('auth.invalid_verification_link')],
            ]);
        }

        // Check if the user is already verified
        if ($user->hasVerifiedEmail()) {
            // Log the user in
            Auth::login($user);
            
            // Redirect based on user role
            if ($user->role === 'seller') {
                // Check if seller has uploaded documents
                if (!$user->profile || is_null($user->profile->verification_doc)) {
                    return redirect()->route('seller.pending-verification');
                }
                // Check if seller documents are verified
                if (!$user->profile->verified_by_admin) {
                    return redirect()->route('seller.pending-verification');
                }
                return redirect()->route('seller.dashboard');
            } else {
                // Check if buyer is approved
                if (!$user->is_verified) {
                    return redirect()->route('buyer.pending-approval');
                }
                return redirect()->route('buyer.dashboard');
            }
        }

        // Validate the ID and hash
        if (!hash_equals((string) $id, (string) $user->getKey()) ||
            !hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            throw ValidationException::withMessages([
                'email' => [trans('auth.invalid_verification_link')],
            ]);
        }

        // Mark email as verified
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
        
        // Log the user in
        Auth::login($user);

        // Redirect based on user role
        if ($user->role === 'seller') {
            return redirect()->route('seller.pending-verification')->with('success', 'Email verified successfully! Please upload your business documents for verification.');
        } else {
            return redirect()->route('buyer.pending-approval')->with('success', 'Email verified successfully! Your account is pending admin approval.');
        }
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            // Redirect based on user role
            if ($request->user()->role === 'seller') {
                // Check if seller has uploaded documents
                if (!$request->user()->profile || is_null($request->user()->profile->verification_doc)) {
                    return redirect()->route('seller.pending-verification');
                }
                // Check if seller documents are verified
                if (!$request->user()->profile->verified_by_admin) {
                    return redirect()->route('seller.pending-verification');
                }
                return redirect()->route('seller.dashboard');
            } else {
                // Check if buyer is approved
                if (!$request->user()->is_verified) {
                    return redirect()->route('buyer.pending-approval');
                }
                return redirect()->route('buyer.dashboard');
            }
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('resent', true);
    }
}