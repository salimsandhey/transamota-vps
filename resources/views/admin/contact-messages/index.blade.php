@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        @include('layouts.nav.admin-sidebar')
        
        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <div class="p-8">
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Contact Messages</h1>
                    <p class="text-gray-600">Manage messages sent through the contact form</p>
                </div>
                
                <!-- Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Messages</p>
                                <p class="text-2xl font-bold text-gray-800">{{ App\Models\ContactMessage::count() }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Unread Messages</p>
                                <p class="text-2xl font-bold text-amber-600">{{ App\Models\ContactMessage::where('is_read', false)->count() }}</p>
                            </div>
                            <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Read Messages</p>
                                <p class="text-2xl font-bold text-green-600">{{ App\Models\ContactMessage::where('is_read', true)->count() }}</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Messages Table -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left text-xs text-gray-500 border-b border-gray-200">
                                    <th class="pb-3 font-medium">Sender</th>
                                    <th class="pb-3 font-medium">Subject</th>
                                    <th class="pb-3 font-medium">Date</th>
                                    <th class="pb-3 font-medium">Status</th>
                                    <th class="pb-3 font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($contactMessages as $message)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-4">
                                            <div>
                                                <div class="font-medium text-gray-800 text-sm">{{ $message->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $message->email }}</div>
                                            </div>
                                        </td>
                                        <td class="py-4">
                                            <div class="text-sm text-gray-800 max-w-xs truncate">{{ $message->subject }}</div>
                                        </td>
                                        <td class="py-4 text-sm text-gray-600">{{ $message->created_at->format('M d, Y H:i') }}</td>
                                        <td class="py-4">
                                            <span class="px-2 py-1 {{ $message->is_read ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }} text-xs rounded-full">
                                                {{ $message->is_read ? 'Read' : 'Unread' }}
                                            </span>
                                        </td>
                                        <td class="py-4">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('admin.contact-messages.show', $message) }}" class="text-blue-600 hover:text-blue-800 text-sm">View</a>
                                                <form action="{{ route('admin.contact-messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-gray-500">
                                            No contact messages found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($contactMessages->hasPages())
                        <div class="mt-6">
                            {{ $contactMessages->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection