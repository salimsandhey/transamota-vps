@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        @include('layouts.nav.admin-sidebar')

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            @include('layouts.nav.content-header', [
                'title' => 'Edit User',
                'subtitle' => 'Update user information',
                'headerActions' => '<a href="' . route('admin.users.index') . '" class="flex items-center gap-2 px-4 py-2 border border-gray-200 rounded-lg text-sm hover:bg-gray-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Users
                </a>'
            ])

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mx-8 mt-6">
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div class="text-green-800 font-medium">{{ session('success') }}</div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Edit User Form -->
            <div class="p-8">
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <!-- User Info -->
                    <div class="flex items-center gap-3 mb-6 p-4 bg-gray-50 rounded-lg">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800">{{ $user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                        </div>
                    </div>

                    <!-- Edit Form -->
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name', $user->name) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @if($errors->has('name'))
                                    <p class="mt-1 text-sm text-red-600">{{ $errors->first('name') }}</p>
                                @endif
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    value="{{ old('email', $user->email) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @if($errors->has('email'))
                                    <p class="mt-1 text-sm text-red-600">{{ $errors->first('email') }}</p>
                                @endif
                            </div>
                            
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                <select 
                                    id="role" 
                                    name="role" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="buyer" {{ old('role', $user->role) == 'buyer' ? 'selected' : '' }}>Buyer</option>
                                    <option value="seller" {{ old('role', $user->role) == 'seller' ? 'selected' : '' }}>Seller</option>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>
                            
                            <div class="flex items-center gap-3 pt-4">
                                <button type="submit" 
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                                    Update User
                                </button>
                                
                                <a href="{{ route('admin.users.index') }}" 
                                   class="px-4 py-2 border border-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-50">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection