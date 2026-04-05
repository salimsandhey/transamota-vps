@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        @include('layouts.nav.admin-sidebar')

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            
            @include('layouts.nav.content-header', [
                'title' => 'Seller Document Verification',
                'subtitle' => 'Review seller details and verify their document',
                'headerActions' => '<a href="' . route('admin.verifications.users.index') . '" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to Verifications
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

            @if(session('error'))
                <div class="mx-8 mt-6">
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="text-red-800 font-medium">{{ session('error') }}</div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="p-8">
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Seller Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Seller Information</h3>
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->phone ?? 'Not provided' }}</div>
                                    </div>
                                </div>
                                
                                <div class="border-t border-gray-200 pt-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Company Name</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $user->company_name ?? 'Not provided' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Location</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $user->city ?? 'Not provided' }}, {{ $user->country ?? 'Not provided' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Role</dt>
                                            <dd class="mt-1 text-sm text-gray-900 capitalize">{{ $user->role }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Email Verified</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                @if($user->email_verified_at)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Verified
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Not Verified
                                                    </span>
                                                @endif
                                            </dd>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($user->profile)
                                <div class="border-t border-gray-200 pt-4">
                                    <h4 class="text-md font-medium text-gray-800 mb-2">Business Information</h4>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Business Type</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $user->profile->business_type ?? 'Not provided' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">GST Number</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $user->profile->gst_no ?? 'Not provided' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Website</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $user->profile->website ?? 'Not provided' }}</dd>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Document Verification -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Document Verification</h3>
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h4 class="text-md font-medium text-gray-800">Business Document</h4>
                                        <p class="text-sm text-gray-500">Uploaded on {{ $user->profile->updated_at->format('M d, Y') }}</p>
                                    </div>
                                    <div>
                                        @if($user->profile->verified_by_admin)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Verified
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Pending Verification
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <a href="{{ route('admin.verifications.users.seller.document', $user) }}" target="_blank" 
                                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-blue-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="-ml-1 mr-2 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                        View Document
                                    </a>
                                </div>
                                
                                @if(!$user->profile->verified_by_admin)
                                <div class="border-t border-gray-200 pt-4">
                                    <h4 class="text-md font-medium text-gray-800 mb-2">Verification Actions</h4>
                                    <div class="flex space-x-3">
                                        <form method="POST" action="{{ route('admin.verifications.users.seller.verify', $user) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                                Verify Document
                                            </button>
                                        </form>
                                        
                                        <form method="POST" action="{{ route('admin.verifications.users.seller.reject', $user) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                                    onclick="return confirm('Are you sure you want to reject this document? This will delete the document and require the seller to upload a new one.')">
                                                <svg class="-ml-1 mr-2 h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                Reject Document
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4 mt-6">
                                <h4 class="text-md font-medium text-gray-800 mb-2">Account Actions</h4>
                                <div class="flex space-x-3">
                                    <a href="{{ route('admin.users.show', $user) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                        View Profile
                                    </a>
                                    
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                                onclick="return confirm('Are you sure you want to delete this user account? This action cannot be undone.')">
                                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            Delete Account
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection