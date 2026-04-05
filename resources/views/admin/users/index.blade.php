@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        @include('layouts.nav.admin-sidebar')

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            @include('layouts.nav.content-header', [
                'title' => 'User Management',
                'subtitle' => 'Manage all users in the system',
                'headerActions' => '<a href="' . route('admin.verifications.users.index') . '" class="flex items-center gap-2 px-4 py-2 bg-amber-600 text-white rounded-lg text-sm hover:bg-amber-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Verify Users
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

            <!-- Users Table -->
            <div class="p-8">
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <!-- Search and Filter -->
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                        <h3 class="text-lg font-semibold text-gray-800">User List</h3>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <form method="GET" class="flex gap-2">
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        name="search" 
                                        placeholder="Search users..." 
                                        value="{{ request('search') }}"
                                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full sm:w-64">
                                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                
                                <select 
                                    name="role" 
                                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">All Roles</option>
                                    <option value="buyer" {{ request('role') == 'buyer' ? 'selected' : '' }}>Buyer</option>
                                    <option value="seller" {{ request('role') == 'seller' ? 'selected' : '' }}>Seller</option>
                                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    Filter
                                </button>
                                
                                @if(request()->has('search') || request()->has('role'))
                                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300">
                                        Clear
                                    </a>
                                @endif
                            </form>
                        </div>
                    </div>

                    <!-- Users Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left text-xs text-gray-500 border-b border-gray-200">
                                    <th class="pb-3 font-medium">User</th>
                                    <th class="pb-3 font-medium">Role</th>
                                    <th class="pb-3 font-medium">Status</th>
                                    <th class="pb-3 font-medium">Created</th>
                                    <th class="pb-3 font-medium text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-800 text-sm">{{ $user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            @if($user->role == 'admin') bg-purple-100 text-purple-800
                                            @elseif($user->role == 'seller') bg-green-100 text-green-800
                                            @else bg-blue-100 text-blue-800 @endif">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="py-4">
                                        @if($user->role == 'seller')
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                @if($user->profile && $user->profile->verified_by_admin) bg-green-100 text-green-800 
                                                @else bg-yellow-100 text-yellow-800 @endif">
                                                @if($user->profile && $user->profile->verified_by_admin) Verified @else Unverified @endif
                                            </span>
                                        @elseif($user->role == 'buyer')
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                @if($user->is_verified) bg-green-100 text-green-800 @else bg-yellow-100 text-yellow-800 @endif">
                                                @if($user->is_verified) Verified @else Unverified @endif
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                                N/A
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 text-sm text-gray-600">
                                        {{ $user->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.users.edit', $user) }}" 
                                               class="text-gray-500 hover:text-gray-700" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            
                                            @if($user->role == 'seller')
                                                <!-- For sellers, show a link to the verification page instead of a toggle button -->
                                                @if($user->profile && $user->profile->verification_doc)
                                                    <a href="{{ route('admin.verifications.users.seller.show', $user) }}" 
                                                       class="text-blue-600 hover:text-blue-800 text-sm"
                                                       title="View Seller Verification">
                                                        @if($user->profile->verified_by_admin)
                                                            <span class="flex items-center">
                                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                </svg>
                                                                View Document
                                                            </span>
                                                        @else
                                                            <span class="flex items-center">
                                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                                </svg>
                                                                Review Document
                                                            </span>
                                                        @endif
                                                    </a>
                                                @else
                                                    <span class="text-xs text-gray-500">No Document</span>
                                                @endif
                                            @else
                                                <!-- For buyers and admins, show the toggle button -->
                                                <form method="POST" action="{{ route('admin.users.verify', $user) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                            class="text-{{ $user->is_verified ? 'yellow' : 'green' }}-600 hover:text-{{ $user->is_verified ? 'yellow' : 'green' }}-800"
                                                            title="{{ $user->is_verified ? 'Unverify' : 'Verify' }}"
                                                            @if($user->role == 'admin') disabled @endif>
                                                        @if($user->is_verified)
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        @else
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        @endif
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if($user->id !== auth()->id())
                                            <button class="text-red-600 hover:text-red-800 delete-user-btn" 
                                                    title="Delete"
                                                    data-user-id="{{ $user->id }}"
                                                    data-user-name="{{ $user->name }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                            @endif
                                            
                                            <!-- Profile Button -->
                                            <a href="{{ route('admin.users.show', $user) }}" 
                                               class="text-blue-600 hover:text-blue-800" title="View Profile">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-gray-500">
                                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <p>No users found</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if(method_exists($users, 'hasPages') && $users->hasPages())
                    <div class="flex items-center justify-between mt-6">
                        <div class="text-sm text-gray-600">
                            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
                        </div>
                        <div class="mt-4">
                            {{ $users->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle delete user
    document.querySelectorAll('.delete-user-btn').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            const userName = this.getAttribute('data-user-name');
            
            // Show custom confirmation popup
            showDeleteConfirmation(userName, function() {
                // Proceed with deletion
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/users/${userId}`;
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
                
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                form.appendChild(csrfInput);
                
                document.body.appendChild(form);
                form.submit();
            });
        });
    });
});

// Custom delete confirmation popup (same as seller products)
function showDeleteConfirmation(userName, onConfirm) {
    // Create overlay
    const overlay = document.createElement('div');
    overlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    overlay.id = 'delete-confirmation-overlay';
    
    // Create modal
    const modal = document.createElement('div');
    modal.className = 'bg-white rounded-lg p-6 max-w-md w-full mx-4';
    modal.innerHTML = `
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Delete User</h3>
            <button id="close-modal" class="text-gray-400 hover:text-gray-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <p class="text-gray-600 mb-6">Are you sure you want to delete the user "<strong>${userName}</strong>"? This action cannot be undone.</p>
        <div class="flex justify-end gap-3">
            <button id="cancel-delete" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                Cancel
            </button>
            <button id="confirm-delete" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                Delete
            </button>
        </div>
    `;
    
    overlay.appendChild(modal);
    document.body.appendChild(overlay);
    
    // Add event listeners
    document.getElementById('close-modal').addEventListener('click', function() {
        document.body.removeChild(overlay);
    });
    
    document.getElementById('cancel-delete').addEventListener('click', function() {
        document.body.removeChild(overlay);
    });
    
    document.getElementById('confirm-delete').addEventListener('click', function() {
        document.body.removeChild(overlay);
        onConfirm();
    });
    
    // Close on escape key
    document.addEventListener('keydown', function closeOnEscape(e) {
        if (e.key === 'Escape') {
            document.body.removeChild(overlay);
            document.removeEventListener('keydown', closeOnEscape);
        }
    });
}
</script>
@endsection