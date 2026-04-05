@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        @include('layouts.nav.seller-sidebar')

        <!-- Main Content -->
        <div id="main-content" class="flex-1 overflow-auto transition-all duration-300 ease-in-out md:ml-0">
            <!-- Profile Header -->
            <div class="bg-white border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="py-6">
                        <h1 class="text-2xl font-bold text-gray-900">Profile Management</h1>
                        <p class="mt-1 text-sm text-gray-500">Manage your personal and business information</p>
                    </div>
                </div>
            </div>
            
            <!-- Profile Navigation -->
            <div class="bg-white border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <nav class="flex space-x-8">
                        <a href="{{ route('seller.profile.personal-info') }}" 
                           class="py-4 px-1 border-b-2 font-medium text-sm {{ request()->routeIs('seller.profile.personal-info') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Personal Info
                        </a>
                        <a href="{{ route('seller.profile.business-info') }}" 
                           class="py-4 px-1 border-b-2 font-medium text-sm {{ request()->routeIs('seller.profile.business-info') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Business Info
                        </a>
                        <a href="{{ route('seller.profile.documents') }}" 
                           class="py-4 px-1 border-b-2 font-medium text-sm {{ request()->routeIs('seller.profile.documents') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Documents
                        </a>
                        <a href="{{ route('seller.profile.settings') }}" 
                           class="py-4 px-1 border-b-2 font-medium text-sm {{ request()->routeIs('seller.profile.settings') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Settings
                        </a>
                    </nav>
                </div>
            </div>
            
            <!-- Profile Content -->
            <div class="p-8">
                <div class="max-w-4xl mx-auto">
                    @yield('profile-content')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection