<!-- Buyer Sidebar -->
<div id="sidebar" class="w-64 bg-white border-r border-gray-200 flex flex-col transition-all duration-300 ease-in-out" style="height: calc(100dvh - 164.67px)">
    <!-- User Profile -->
    <div class="p-4 border-b border-gray-200">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div id="user-info" class="flex-1 min-w-0 user-info">
                <div class="font-medium text-gray-800 truncate">{{ Auth::user()->company_name ?? Auth::user()->name ?? 'Buyer' }}</div>
                <div class="text-xs text-gray-500 truncate">{{ Auth::user()->email ?? 'buyer@example.com' }}</div>
            </div>
            <!-- Collapse Button -->
            <button id="sidebar-toggle" class="md:flex items-center justify-center p-1 rounded-lg hover:bg-gray-100">
                <svg id="toggle-icon" class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Main Menu -->
    <div class="flex-1 overflow-y-auto p-4">
        <div id="main-menu-label" class="text-xs font-semibold text-gray-500 mb-3 menu-label">Main Menu</div>
        <div class="space-y-1">
            <a href="{{ route('buyer.dashboard') }}" title="Dashboard" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('buyer.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                <!-- Updated Dashboard SVG icon -->
                <svg class="w-5 h-5 flex-shrink-0 text-gray-600 dashboard-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span id="dashboard-text" class="flex-1 text-left truncate sidebar-text">Dashboard</span>
            </a>
            <a href="{{ route('products.browse') }}" title="Browse Products" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('products.browse') || request()->routeIs('products.show') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} transition-colors">
                <svg class="w-5 h-5 flex-shrink-0 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span id="products-text" class="flex-1 text-left truncate sidebar-text">Browse Products</span>
            </a>
            <!-- <a href="{{ route('buyer.orders') }}" title="My Orders" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 flex-shrink-0 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <span id="orders-text" class="flex-1 text-left truncate sidebar-text">My Orders</span>
                <span class="bg-blue-600 text-white text-xs px-2 py-0.5 rounded-full notification-badge">0</span>
            </a> -->
            <a href="{{ route('inquiries.index') }}" title="My Inquiries" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('inquiries.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} transition-colors">
                <!-- Updated Inquiries SVG icon -->
                <svg class="w-5 h-5 flex-shrink-0 text-gray-600 inquiries-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                </svg>
                <span id="inquiries-text" class="flex-1 text-left truncate sidebar-text">My Inquiries</span>
            </a>
            <a href="{{ route('chat.index') }}" title="Messages" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('chat.index') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} transition-colors">
                <svg class="w-5 h-5 flex-shrink-0 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <span id="messages-text" class="flex-1 text-left truncate sidebar-text">Messages</span>
                @if(auth()->user()->buyerConversations()->whereHas('messages', function($query) {
                    $query->where('seen', false)->where('sender_id', '!=', auth()->id());
                })->count() > 0)
                    <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full notification-badge">{{ auth()->user()->buyerConversations()->whereHas('messages', function($query) {
                        $query->where('seen', false)->where('sender_id', '!=', auth()->id());
                    })->count() }}</span>
                @endif
            </a>
            <a href="{{ route('group-chat.index') }}" title="Group Chat" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('group-chat.index') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} transition-colors">
                <svg class="w-5 h-5 flex-shrink-0 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                </svg>
                <span id="group-chat-text" class="flex-1 text-left truncate sidebar-text">Group Chat</span>
            </a>
        </div>

        <div id="saved-label" class="text-xs font-semibold text-gray-500 mt-6 mb-3 menu-label">Saved</div>
        <div class="space-y-1">
            <a href="{{ route('favorites.index') }}" title="My Favorites" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('favorites.index') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} transition-colors">
                <svg class="w-5 h-5 flex-shrink-0 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                <span id="favorites-text" class="flex-1 text-left truncate sidebar-text">My Favorites</span>
                <span class="bg-blue-600 text-white text-xs px-2 py-0.5 rounded-full notification-badge">{{ auth()->user()->favorites()->count() }}</span>
            </a>
            <!-- <a href="{{ route('buyer.saved-products') }}" title="Saved Products" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 flex-shrink-0 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                </svg>
                <span id="saved-products-text" class="flex-1 text-left truncate sidebar-text">Saved Products</span>
            </a> -->
            <!-- <a href="{{ route('buyer.reviews') }}" title="My Reviews" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 flex-shrink-0 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                <span id="reviews-text" class="flex-1 text-left truncate sidebar-text">My Reviews</span>
            </a> -->
        </div>

        <!-- Public Links Section -->
        <div id="public-links-label" class="text-xs font-semibold text-gray-500 mt-6 mb-3 menu-label">Public Links</div>
        <div class="space-y-1">
            <a href="{{ route('welcome') }}" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 flex-shrink-0 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="flex-1 text-left truncate">Home</span>
            </a>
            <a href="{{ route('contact') }}" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 flex-shrink-0 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <span class="flex-1 text-left truncate">Contact Us</span>
            </a>
        </div>

        <div id="other-menu-label" class="text-xs font-semibold text-gray-500 mt-6 mb-3 menu-label">Other Menu</div>
        <div class="space-y-1">
            <a href="{{ route('buyer.profile.index') }}" title="Profile" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-50">
                <svg class="w-5 h-5 flex-shrink-0 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span id="profile-text" class="flex-1 text-left truncate sidebar-text">Profile</span>
            </a>
            <!-- <a href="{{ route('buyer.settings') }}" title="Settings" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-50">
                <svg class="w-5 h-5 flex-shrink-0 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span id="settings-text" class="flex-1 text-left truncate sidebar-text">Settings</span>
            </a> -->
            <a href="/faq" title="FAQ" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-50">
                <svg class="w-5 h-5 flex-shrink-0 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span id="support-text" class="flex-1 text-left truncate sidebar-text">Help and Support</span>
            </a>
            <a href="{{ route('logout') }}" title="Log Out" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-50">
                <svg class="w-5 h-5 flex-shrink-0 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span id="logout-text" class="flex-1 text-left truncate sidebar-text">Log Out</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>
</div>

<!-- Overlay for mobile -->
<div id="sidebar-overlay" class="md:hidden fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>