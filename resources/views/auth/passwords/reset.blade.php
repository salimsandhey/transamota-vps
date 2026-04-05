@extends('layouts.app')

@section('title', 'Reset Password - Transamota')

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
                    <h2 class="text-2xl font-bold text-gray-900">Reset Password</h2>
                    <p class="text-gray-600 mt-2">Enter your new password below.</p>
                </div>
                
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
                    
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ $email ?? old('email') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               placeholder="you@example.com" required readonly>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-5">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" 
                                   class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                   placeholder="••••••••" required>
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg id="eyeIcon" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg id="eyeSlashIcon" class="w-5 h-5 text-gray-500 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-5">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                   class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                   placeholder="••••••••" required>
                            <button type="button" id="togglePasswordConfirmation" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg id="eyeIconConfirmation" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg id="eyeSlashIconConfirmation" class="w-5 h-5 text-gray-500 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                </svg>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" class="w-full px-4 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Reset Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Password toggle for password field
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    const eyeSlashIcon = document.getElementById('eyeSlashIcon');
    
    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        if (type === 'password') {
            eyeIcon.classList.remove('hidden');
            eyeSlashIcon.classList.add('hidden');
        } else {
            eyeIcon.classList.add('hidden');
            eyeSlashIcon.classList.remove('hidden');
        }
    });
    
    // Password toggle for password confirmation field
    const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');
    const passwordConfirmation = document.getElementById('password_confirmation');
    const eyeIconConfirmation = document.getElementById('eyeIconConfirmation');
    const eyeSlashIconConfirmation = document.getElementById('eyeSlashIconConfirmation');
    
    togglePasswordConfirmation.addEventListener('click', function() {
        const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConfirmation.setAttribute('type', type);
        
        if (type === 'password') {
            eyeIconConfirmation.classList.remove('hidden');
            eyeSlashIconConfirmation.classList.add('hidden');
        } else {
            eyeIconConfirmation.classList.add('hidden');
            eyeSlashIconConfirmation.classList.remove('hidden');
        }
    });
</script>
@endsection