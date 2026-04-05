@extends('layouts.app')

@section('title', 'Email Verification - Transamota')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <div class="p-8">
                <div class="max-w-3xl mx-auto">
                    <div class="bg-white rounded-xl border border-gray-200 p-8 text-center">
                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100">
                            <svg class="h-10 w-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Verify Your Email Address</h3>
                        <div class="mt-2 text-sm text-gray-500">
                            <p>We've sent a verification email to <strong>{{ auth()->user()->email }}</strong>.</p>
                            <p class="mt-2">Please check your email and click the verification link to continue.</p>
                        </div>
                        
                        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4 text-left">
                            <div class="flex">
                                <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Didn't receive the email?</h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <p>Check your spam folder or click the button below to resend the verification email.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Resend Verification Email
                                </button>
                            </form>
                            
                            <a href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="mt-3 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Logout
                            </a>
                            
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection