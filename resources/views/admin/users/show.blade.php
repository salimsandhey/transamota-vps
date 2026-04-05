@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        @include('layouts.nav.admin-sidebar')

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            @include('layouts.nav.content-header', [
                'title' => 'User Profile',
                'subtitle' => 'Detailed information about the user',
                'headerActions' => '<a href="' . route('admin.users.index') . '" class="flex items-center gap-2 px-4 py-2 border border-gray-200 rounded-lg text-sm hover:bg-gray-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Users
                </a>'
            ])

            <!-- User Profile Card -->
            <div class="p-8">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <!-- User Header -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 border-b border-gray-200">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h2>
                                <p class="text-gray-600">{{ $user->email }}</p>
                                <div class="mt-2">
                                    <span class="px-3 py-1 text-xs rounded-full 
                                        @if($user->role == 'admin') bg-purple-100 text-purple-800
                                        @elseif($user->role == 'seller') bg-green-100 text-green-800
                                        @else bg-blue-100 text-blue-800 @endif">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                    @if($user->is_verified)
                                        <span class="ml-2 px-3 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                            Verified
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Details -->
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Information -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Basic Information</h3>
                                <div class="space-y-4">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Name:</span>
                                        <span class="font-medium">{{ $user->name }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Email:</span>
                                        <span class="font-medium">{{ $user->email }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Phone:</span>
                                        <span class="font-medium">{{ $user->phone ?? 'Not provided' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Company:</span>
                                        <span class="font-medium">{{ $user->company_name ?? 'Not provided' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Location:</span>
                                        <span class="font-medium">{{ $user->city ?? 'Not provided' }}, {{ $user->country ?? '' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Role:</span>
                                        <span class="font-medium capitalize">{{ $user->role }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Account Status:</span>
                                        <span class="font-medium">
                                            @if($user->is_verified)
                                                <span class="text-green-600">Verified</span>
                                            @else
                                                <span class="text-yellow-600">Unverified</span>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Member Since:</span>
                                        <span class="font-medium">{{ $user->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Additional Information</h3>
                                @if($user->profile)
                                    <div class="space-y-4">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Business Type:</span>
                                            <span class="font-medium">{{ $user->profile->business_type ?? 'Not provided' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Website:</span>
                                            <span class="font-medium">{{ $user->profile->website ?? 'Not provided' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">GST Number:</span>
                                            <span class="font-medium">{{ $user->profile->gst_no ?? 'Not provided' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Document Type:</span>
                                            <span class="font-medium">{{ $user->profile->document_type_name ?? 'Not provided' }}</span>
                                        </div>
                                        @if($user->role == 'seller')
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Admin Verified:</span>
                                                <span class="font-medium">
                                                    @if($user->profile->verified_by_admin)
                                                        <span class="text-green-600">Yes</span>
                                                    @else
                                                        <span class="text-yellow-600">No</span>
                                                    @endif
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-gray-500">No additional information available.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-8 pt-6 border-t border-gray-200 flex gap-3">
                            <a href="{{ route('admin.users.edit', $user) }}" 
                               class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                                Edit User
                            </a>
                            
                            @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700"
                                            onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                        Delete User
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection