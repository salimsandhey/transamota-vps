@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        @include('layouts.nav.admin-sidebar')
        
        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <div class="p-8">
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">System Settings</h1>
                    <p class="text-gray-600">Configure system-wide settings</p>
                </div>
                
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-6">Contact Settings</h2>
                    
                    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label for="admin_email" class="block text-sm font-medium text-gray-700 mb-2">Admin Email Address</label>
                            <input type="email" id="admin_email" name="admin_email" value="{{ old('admin_email', $adminEmail) }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="mt-2 text-sm text-gray-500">All contact form submissions will be sent to this email address.</p>
                            @error('admin_email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="pt-4">
                            <button type="submit" 
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
                                Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection