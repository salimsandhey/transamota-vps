<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm(Request $request)
    {
        // Store the redirect URL in session if provided
        if ($request->has('redirect')) {
            $request->session()->put('url.intended', $request->get('redirect'));
        }
        
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Store the redirect URL in session if provided
            if ($request->has('redirect')) {
                $request->session()->put('url.intended', $request->get('redirect'));
            }

            // Redirect to respective dashboard based on user role and verification status
            $user = Auth::user();
            
            // Save user's timezone if provided
            if ($request->has('timezone')) {
                $user->timezone = $request->timezone;
                $user->save();
            }
            
            // Check if email is verified
            if (is_null($user->email_verified_at)) {
                return redirect()->route('verification.notice');
            }
            
            if ($user->role === 'seller') {
                // Check if seller has uploaded and verified documents
                if (!$user->profile || is_null($user->profile->verification_doc) || !$user->profile->verified_by_admin) {
                    return redirect()->route('seller.pending-verification');
                }
                return redirect()->intended('/');
            } else {
                // Check if buyer is approved
                if (!$user->is_verified) {
                    return redirect()->route('buyer.pending-approval');
                }
                return redirect()->intended('/');
            }
        }

        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}