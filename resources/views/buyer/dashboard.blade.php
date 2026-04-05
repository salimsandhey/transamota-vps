@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        @include('layouts.nav.buyer-sidebar')

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
                            ['icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z', 'label' => 'Total Orders', 'value' => $totalOrders ?? '0', 'change' => '5% vs last month', 'positive' => true],
                            ['icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'label' => 'Total Spent', 'value' => '₹' . number_format($totalSpent ?? 0, 2), 'change' => '12% vs last month', 'positive' => true],
                            ['icon' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z', 'label' => 'Messages', 'value' => auth()->user()->buyerConversations()->whereHas('messages', function($query) {
                    $query->where('seen', false)->where('sender_id', '!=', auth()->id());
                })->count(), 'change' => 'Unread messages', 'positive' => true],
                            ['icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'label' => 'Saved Products', 'value' => $savedProducts ?? '0', 'change' => '8% vs last month', 'positive' => true]
                        ];
                    @endphp

                    @foreach($stats as $stat)
                        <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2 text-gray-600">
                                    <svg class="w-5 h-5 {{ $stat['label'] == 'Total Orders' ? 'text-blue-500' : ($stat['label'] == 'Total Spent' ? 'text-green-500' : ($stat['label'] == 'Messages' ? 'text-purple-500' : 'text-amber-500')) }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"></path>
                                    </svg>
                                    <span class="text-sm font-medium">{{ $stat['label'] }}</span>
                                </div>
                                @if($stat['label'] == 'Messages')
                                    <a href="{{ route('chat.index') }}" class="text-gray-400 hover:text-gray-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                            <div class="text-3xl font-bold text-gray-800 mb-2">{{ $stat['value'] }}</div>
                            <div class="text-xs {{ $stat['positive'] ? 'text-green-600' : 'text-red-600' }} flex items-center gap-1">
                                <span>{{ $stat['positive'] ? '▲' : '▼' }}</span>
                                <span>{{ $stat['change'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Recent Orders and Wishlist --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    {{-- Recent Orders --}}
                    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-sm font-medium text-gray-600 mb-2">Recent Orders</h3>
                                <div class="text-2xl font-bold text-gray-800">{{ $recentOrdersCount ?? 0 }} Orders</div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button class="px-3 py-1 text-xs rounded bg-gray-100 text-gray-800">All</button>
                                <button class="px-3 py-1 text-xs rounded text-gray-500 hover:bg-gray-50">Pending</button>
                                <button class="px-3 py-1 text-xs rounded text-gray-500 hover:bg-gray-50">Delivered</button>
                                <a href="{{ route('buyer.orders') }}" class="text-blue-600 text-sm hover:text-blue-800">View All</a>
                            </div>
                        </div>
                        <div class="space-y-4">
                            @forelse($recentOrders ?? [] as $order)
                            <div class="flex items-center justify-between p-4 hover:bg-gray-50 rounded-lg transition-colors">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-800">{{ Str::limit($order->product_name, 25) }}</div>
                                        <div class="text-xs text-gray-500">Order #{{ $order->id }} • {{ $order->date }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-medium text-gray-800">₹{{ number_format($order->total, 2) }}</div>
                                    <span class="text-xs px-2 py-0.5 rounded-full
                                        @if($order->status == 'delivered') bg-green-100 text-green-800
                                        @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8 text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                <p>No recent orders</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Wishlist --}}
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-sm font-medium text-gray-800">Saved Products</h3>
                            <a href="{{ route('buyer.saved-products') }}" class="text-blue-600 text-sm hover:text-blue-800">View All</a>
                        </div>
                        <div class="space-y-4">
                            @forelse($savedProductsList ?? [] as $product)
                            <div class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-medium text-gray-800 text-sm">{{ Str::limit($product->name, 20) }}</div>
                                    <div class="text-xs text-gray-500">{{ $product->category->name ?? 'N/A' }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-medium text-gray-800">{{ $product->price ? '₹' . number_format($product->price, 2) : 'Price on request' }}</div>
                                    <button class="text-blue-600 text-xs hover:text-blue-800">Add to Cart</button>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8 text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <p>No saved products</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Recent Conversations -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 mb-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-sm font-medium text-gray-800">Recent Conversations</h3>
                        <a href="{{ route('chat.index') }}" class="text-blue-600 text-sm hover:text-blue-800">View All Messages</a>
                    </div>
                    <div class="space-y-4">
                        @forelse(auth()->user()->buyerConversations()->with(['seller', 'messages'])->latest('updated_at')->take(3)->get() as $conversation)
                            <a href="{{ route('chat.show', $conversation->slug) }}" class="block border border-gray-200 rounded-lg p-3 hover:bg-gray-50 transition-colors">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $conversation->seller->name }}</h4>
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

                <!-- Recently Viewed Products -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-sm font-medium text-gray-800">Recently Viewed</h3>
                        <a href="{{ route('products.browse') }}" class="text-blue-600 text-sm hover:text-blue-800">Browse More</a>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        @forelse($recentlyViewed ?? [] as $product)
                        <div class="border border-gray-200 rounded-lg p-3 hover:shadow-md transition-shadow">
                            <div class="bg-gray-200 rounded-lg h-24 flex items-center justify-center mb-2">
                                <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                </svg>
                            </div>
                            <div class="font-medium text-gray-800 text-sm">{{ Str::limit($product->name, 20) }}</div>
                            <div class="text-xs text-gray-500">{{ $product->category->name ?? 'N/A' }}</div>
                            <div class="flex items-center justify-between mt-1">
                                <span class="font-medium text-gray-800">{{ $product->price ? '₹' . number_format($product->price, 2) : 'Price on request' }}</span>
                                <button class="text-blue-600 hover:text-blue-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <p>No recently viewed products</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection