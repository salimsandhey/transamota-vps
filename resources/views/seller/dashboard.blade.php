@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        @include('layouts.nav.seller-sidebar')

        <!-- Main Content -->
        <div id="main-content" class="flex-1 overflow-auto transition-all duration-300 ease-in-out">
            <!-- Success Message -->
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

            <!-- Stats Grid -->
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    @php
                        $stats = [
                            ['icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', 'label' => 'Active Products', 'value' => $totalActiveProducts ?? '0', 'change' => 'Currently active', 'positive' => true],
                            ['icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'label' => 'Pending Approvals', 'value' => $pendingApprovals ?? '0', 'change' => 'Awaiting review', 'positive' => false],
                            ['icon' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z', 'label' => 'Unread Messages', 'value' => $unreadMessages ?? '0', 'change' => 'New messages', 'positive' => true],
                            ['icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z', 'label' => 'New Inquiries', 'value' => $pendingInquiries ?? '0', 'change' => 'This week', 'positive' => true]
                        ];
                    @endphp

                    @foreach($stats as $stat)
                        <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2 text-gray-600">
                                    <svg class="w-5 h-5 {{ $stat['label'] == 'Active Products' ? 'text-blue-500' : ($stat['label'] == 'Pending Approvals' ? 'text-amber-500' : ($stat['label'] == 'Unread Messages' ? 'text-purple-500' : 'text-green-500')) }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"></path>
                                    </svg>
                                    <span class="text-sm font-medium">{{ $stat['label'] }}</span>
                                </div>
                                @if($stat['label'] == 'Unread Messages')
                                    <a href="{{ route('chat.index') }}" class="text-gray-400 hover:text-gray-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                            <div class="text-3xl font-bold text-gray-800 mb-2">{{ $stat['value'] }}</div>
                            <div class="text-xs {{ $stat['positive'] ? 'text-green-600' : 'text-amber-600' }} flex items-center gap-1">
                                <span>{{ $stat['positive'] ? '●' : '▲' }}</span>
                                <span>{{ $stat['change'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Recent Activity --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    {{-- Recent Inquiries --}}
                    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-sm font-medium text-gray-600 mb-2">Recent Inquiries</h3>
                                <div class="text-lg font-bold text-gray-800">From Buyers</div>
                            </div>
                            <a href="{{ route('seller.inquiries') }}" class="text-blue-600 text-sm hover:text-blue-800">View All</a>
                        </div>
                        <div class="space-y-4">
                            @forelse($recentInquiries ?? [] as $inquiry)
                                <div class="flex items-center gap-4 text-sm border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                                    <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="font-medium text-gray-800">{{ Str::limit($inquiry->product->name, 25) }}</div>
                                        <div class="text-xs text-gray-500">From: {{ $inquiry->conversation->buyer->name }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xs text-gray-500">{{ $inquiry->added_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-gray-500">
                                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                    </svg>
                                    <p>No recent inquiries</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Recent Conversations --}}
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-sm font-medium text-gray-800">Recent Conversations</h3>
                            <a href="{{ route('chat.index') }}" class="text-blue-600 text-sm hover:text-blue-800">View All Messages</a>
                        </div>
                        <div class="space-y-4">
                            @forelse($recentConversations ?? [] as $conversation)
                                <a href="{{ route('chat.show', $conversation->slug) }}" class="block border border-gray-200 rounded-lg p-3 hover:bg-gray-50 transition-colors">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $conversation->buyer->name }}</h4>
                                            <p class="text-sm text-gray-500 mt-1 truncate max-w-xs">
                                                {{ $conversation->last_message ?? 'No messages yet' }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-xs text-gray-500">
                                                {{ $conversation->updated_at->diffForHumans() }}
                                            </div>
                                            @if($conversation->messages()->where('seen', false)->where('sender_id', '!=', auth()->id())->count() > 0)
                                                <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-red-500 text-white text-xs mt-1">
                                                    {{ $conversation->messages()->where('seen', false)->where('sender_id', '!=', auth()->id())->count() }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-4 text-gray-500">
                                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    <p>No conversations yet</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Products Needing Attention --}}
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-1">Products Needing Attention</h3>
                            <p class="text-sm text-gray-500">Pending approvals or recently added</p>
                        </div>
                        <a href="{{ route('seller.products') }}" class="text-blue-600 text-sm hover:text-blue-800">View All Products</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left text-xs text-gray-500 border-b border-gray-200">
                                    <th class="pb-3 font-medium">Product</th>
                                    <th class="pb-3 font-medium">Category</th>
                                    <th class="pb-3 font-medium">Status</th>
                                    <th class="pb-3 font-medium">Added</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($productsNeedingAttention ?? [] as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-800 text-sm">{{ Str::limit($product->name, 25) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 text-sm text-gray-600">{{ $product->category->name ?? 'N/A' }}</td>
                                    <td class="py-4">
                                        <span class="px-2 py-1 rounded text-xs 
                                            @if($product->verification_status == 'approved') bg-emerald-100 text-emerald-800
                                            @elseif($product->verification_status == 'pending') bg-amber-100 text-amber-800
                                            @elseif($product->verification_status == 'rejected') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($product->verification_status) }}
                                        </span>
                                    </td>
                                    <td class="py-4 text-sm text-gray-600">{{ $product->created_at->diffForHumans() }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-gray-500">
                                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                        <p>No products needing attention</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection