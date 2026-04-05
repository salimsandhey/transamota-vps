@extends('layouts.app')

@section('title', 'Pending Verification - Transamota')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        @include('layouts.nav.seller-sidebar')

        <!-- Main Content -->
        <div id="main-content" class="flex-1 overflow-auto transition-all duration-300 ease-in-out md:ml-0">
            @include('layouts.nav.content-header', [
                'title' => 'Account Pending Verification',
                'subtitle' => 'Your account is awaiting document verification',
            ])

            <div class="p-8">
                <div class="max-w-3xl mx-auto">
                    <div class="bg-white rounded-xl border border-gray-200 p-8 text-center">
                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100">
                            <svg class="h-10 w-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Account Pending Verification</h3>
                        <div class="mt-2 text-sm text-gray-500">
                            <p>Your seller account requires document verification before you can access all features.</p>
                        </div>
                        
                        @if(Auth::user()->profile->verification_doc)
                            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4 text-left">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800">Document Uploaded</h3>
                                        <div class="mt-2 text-sm text-blue-700">
                                            <p>You have uploaded the following document for verification:</p>
                                            <p class="mt-1 font-medium">{{ Auth::user()->profile->document_type_name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-left">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-yellow-800">Waiting for Admin Approval</h3>
                                        <div class="mt-2 text-sm text-yellow-700">
                                            <p>Your document is currently under review. Please wait for admin approval.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-left">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-yellow-800">Required Steps</h3>
                                        <div class="mt-2 text-sm text-yellow-700">
                                            <ul class="list-disc pl-5 space-y-1">
                                                <li>Upload your business registration certificate or license</li>
                                                <li>Upload a government-issued ID (passport, driver's license, etc.)</li>
                                                <li>Upload bank account details or voided check</li>
                                                <li>Upload GST registration certificate (if applicable)</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <div class="mt-6">
                            <a href="{{ route('seller.profile.documents') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                {{ Auth::user()->profile->verification_doc ? 'Change Document' : 'Upload Documents' }}
                            </a>
                            <p class="mt-2 text-xs text-gray-500">You will be taken to the documents page where you can {{ Auth::user()->profile->verification_doc ? 'change your business verification document' : 'upload your business verification documents' }}.</p>
                            
                            <a href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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