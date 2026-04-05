@extends('buyer.profile.base')

@section('profile-content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Profile Summary Card -->
    <div class="lg:col-span-1 bg-white rounded-xl border border-gray-200 p-6">
        <div class="text-center">
            <div class="mx-auto w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                <span class="text-blue-600 font-bold text-2xl">{{ substr(Auth::user()->name, 0, 1) }}</span>
            </div>
            <h2 class="text-xl font-bold text-gray-900">{{ Auth::user()->name }}</h2>
            <p class="text-gray-500">{{ Auth::user()->email }}</p>
            <div class="mt-4 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                {{ ucfirst(Auth::user()->role) }}
            </div>
        </div>
        
        <div class="mt-6 space-y-4">
            <div class="flex items-center text-sm">
                <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
                <span>{{ Auth::user()->phone ?? 'Not provided' }}</span>
            </div>
            
            <div class="flex items-center text-sm">
                <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>{{ Auth::user()->city ?? 'Not provided' }}, {{ Auth::user()->country ?? 'Not provided' }}</span>
            </div>
            
            <div class="flex items-center text-sm">
                <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>Member since {{ Auth::user()->created_at->format('M Y') }}</span>
            </div>
        </div>
        
        <div class="mt-6">
            <a href="{{ route('buyer.profile.personal-info') }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                Edit Profile
            </a>
        </div>
    </div>
    
    <!-- Profile Completion and Quick Actions -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Profile Completion -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Profile Completion</h3>
                <span class="text-sm font-medium text-blue-600">65%</span>
            </div>
            
            <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
                <div class="bg-blue-600 h-2 rounded-full" style="width: 65%"></div>
            </div>
            
            <div class="space-y-2 text-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Personal Information</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Business Information</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span>Upload Documents</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span>Verification Status</span>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('buyer.profile.personal-info') }}" class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">Personal Info</div>
                            <div class="text-sm text-gray-500">Update your details</div>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('buyer.profile.business-info') }}" class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">Business Info</div>
                            <div class="text-sm text-gray-500">Manage business details</div>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('buyer.profile.documents') }}" class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">Documents</div>
                            <div class="text-sm text-gray-500">Upload verification docs</div>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('buyer.profile.settings') }}" class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">Settings</div>
                            <div class="text-sm text-gray-500">Manage preferences</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        
        <!-- Verification Status -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Verification Status</h3>
            
            <div class="flex items-center p-4 bg-amber-50 rounded-lg">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-amber-800">Pending Verification</h3>
                    <div class="mt-2 text-sm text-amber-700">
                        <p>Your account is pending verification. Upload required documents to get verified.</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <a href="{{ route('buyer.profile.documents') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Upload Documents
                </a>
            </div>
        </div>
    </div>
</div>
@endsection