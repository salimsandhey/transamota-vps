@extends(auth()->user()->role === 'seller' ? 'layouts.app' : 'layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        @if(auth()->user()->role === 'seller')
            @include('layouts.nav.seller-sidebar')
        @else
            @include('layouts.nav.buyer-sidebar')
        @endif

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <div class="p-6 h-full">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col" style="height: calc(100vh - 100px);"> 
                    <div class="border-b border-gray-200 px-6 py-4 flex-shrink-0">
                        <h2 class="text-lg font-semibold text-gray-900">Conversations</h2>
                    </div>
                    
                    @if($conversations->isEmpty())
                        <div class="flex items-center justify-center flex-1">
                            <div class="text-center">
                                <div class="mx-auto w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center mb-6">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No conversations yet</h3>
                                <p class="text-gray-500 max-w-md mx-auto">You don't have any conversations. Start chatting with sellers to see conversations here.</p>
                            </div>
                        </div>
                    @else
                        <div class="overflow-y-auto flex-1">
                            @foreach($conversations as $conversation)
                                <a href="{{ route('chat.show', $conversation->slug) }}" class="block px-6 py-4 hover:bg-gray-50 transition-colors  border-b border-gray-100">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                                            <span class="text-blue-800 font-medium">
                                                @if(auth()->user()->role === 'seller')
                                                    {{ substr($conversation->buyer->name, 0, 1) }}
                                                @else
                                                    {{ substr($conversation->seller->name, 0, 1) }}
                                                @endif
                                            </span>
                                        </div>
                                        <div class="ml-4 flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <h4 class="font-medium text-gray-900 truncate">
                                                    @if(auth()->user()->role === 'seller')
                                                        {{ $conversation->buyer->name }}
                                                    @else
                                                        {{ $conversation->seller->name }}
                                                    @endif
                                                </h4>
                                                <div class="text-xs text-gray-500 whitespace-nowrap ml-2">
                                                    {{ $conversation->updated_at->diffForHumans() }}
                                                </div>
                                            </div>
                                            <p class="text-sm text-gray-500 truncate mt-1">
                                                {{ $conversation->last_message ?? 'No messages yet' }}
                                            </p>
                                        </div>
                                        @if($conversation->unread_count > 0)
                                            <div class="ml-4 flex-shrink-0">
                                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-blue-600 text-white text-xs font-medium">
                                                    {{ $conversation->unread_count }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection