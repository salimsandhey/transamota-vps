@extends(auth()->user()->role === 'seller' ? 'layouts.app' : 'layouts.app')

@section('content')
<div class="flex flex-col " style="height: calc(100dvh - 164.67px)">
    <div class="flex flex-1 overflow-hidden">
        @if(auth()->user()->role === 'seller')
            @include('layouts.nav.seller-sidebar')
        @else
            @include('layouts.nav.buyer-sidebar')
        @endif

        <!-- Main Content -->
        <div class="flex-1 overflow-hidden">
            <div class="h-full">
                <div class="bg-white shadow-sm border border-gray-200 overflow-hidden flex flex-col h-full"> 
                    <div class="border-b border-gray-200 px-6 py-4 flex-shrink-0">
                        <h2 class="text-lg font-semibold text-gray-900">Group Chats</h2>
                    </div>
                    
                    @if($groupChats->isEmpty())
                        <div class="flex items-center justify-center flex-1">
                            <div class="text-center">
                                <div class="mx-auto w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center mb-6">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No Groups Available</h3>
                                <p class="text-gray-500 max-w-md mx-auto">You haven't been assigned to any group chats yet. Please contact support if you believe this is an error.</p>
                            </div>
                        </div>
                    @else
                        <div class="overflow-y-auto flex-1">
                            @foreach($groupChats as $groupChat)
                                <a href="{{ route('group-chat.show', $groupChat->id) }}" class="block px-6 py-4 hover:bg-gray-50 transition-colors border-b border-gray-100">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                                            <span class="text-blue-800 font-medium">
                                                {{ substr($groupChat->name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div class="ml-4 flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <h4 class="font-medium text-gray-900 truncate">
                                                    {{ $groupChat->name }}
                                                </h4>
                                                <div class="text-xs text-gray-500 whitespace-nowrap ml-2">
                                                    {{ $groupChat->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                            <p class="text-sm text-gray-500 truncate mt-1">
                                                {{ $groupChat->description ?? 'No description' }}
                                            </p>
                                            <p class="text-xs text-gray-400 mt-1">
                                                {{ $groupChat->users->count() }} members
                                            </p>
                                        </div>
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