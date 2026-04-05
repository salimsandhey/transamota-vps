@extends('layouts.app')

@section('title', 'Pending Approval - Transamota')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        <!-- Main Content -->
        <div id="main-content" class="flex-1 overflow-auto transition-all duration-300 ease-in-out">
            @include('layouts.nav.content-header', [
                'title' => 'Account Pending Approval',
                'subtitle' => 'Your account is awaiting admin approval',
            ])

            <div class="p-8">
                <div class="max-w-3xl mx-auto">
                    <div class="bg-white rounded-xl border border-gray-200 p-8 text-center">
                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100">
                            <svg class="h-10 w-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Account Pending Approval</h3>
                        <div class="mt-2 text-sm text-gray-500">
                            <p>Your buyer account is awaiting approval from our admin team.</p>
                            <p class="mt-2">You'll be notified via email once your account has been approved.</p>
                        </div>
                        
                        <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-left">
                            <div class="flex">
                                <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">What happens next?</h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            <li>Our admin team will review your account information</li>
                                            <li>You'll receive an email notification once approved</li>
                                            <li>After approval, you can browse products and contact sellers</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <a href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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