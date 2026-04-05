@extends('layouts.app')

@section('title', 'Forgot Password - Transamota')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50 items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                <div class="text-center mb-8">
                    <div class="flex justify-center mb-4">
                        <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                            <div class="text-white font-bold text-xl">T</div>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Forgot Password</h2>
                    <p class="text-gray-600 mt-2">Enter your email address and we'll send you a link to reset your password.</p>
                </div>
                
                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-50 text-green-800 rounded-lg">
                        {{ session('status') }}
                    </div>
                @endif
                
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               placeholder="you@example.com" required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" class="w-full px-4 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Send Password Reset Link
                    </button>
                </form>
                
                <div class="mt-6 text-center text-sm text-gray-600">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">← Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection