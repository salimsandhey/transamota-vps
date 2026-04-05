<!-- Public Header - Two Tier Design for B2B Marketplace -->
<header class="bg-white shadow-sm sticky top-0 z-50 mobile-header">
    <!-- Top Bar - Navigation, Auth, and Utility Links -->
    <div class="bg-gray-100 py-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center text-sm">
                <div class="flex space-x-6">
                    <a href="{{ route('sell') }}" class="text-gray-600 hover:text-blue-600 hidden md:inline">Sell on Transamota</a>
                    <a href="{{ route('services') }}" class="text-gray-600 hover:text-blue-600 hidden md:inline">Trade Services</a>
                    <a href="{{ route('contact') }}" class="text-gray-600 hover:text-blue-600">Contact Us</a>
                    <a href="{{ route('faq') }}" class="text-gray-600 hover:text-blue-600 hidden md:inline">FAQ</a>
                    <a href="{{ route('safety-tips') }}" class="text-gray-600 hover:text-blue-600 hidden md:inline">Safety Tips</a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-blue-600 font-semibold hidden md:inline">Admin Dashboard</a>
                        @elseif(Auth::user()->role === 'seller')
                            <a href="{{ route('seller.dashboard') }}" class="text-blue-600 font-semibold hidden md:inline">Seller Dashboard</a>
                        @else
                            <a href="{{ route('buyer.dashboard') }}" class="text-blue-600 font-semibold hidden md:inline">Buyer Dashboard</a>
                        @endif
                        
                        <div class="relative">
                            <button id="user-menu-button" class="flex items-center space-x-1 text-gray-700 hover:text-blue-600">
                                <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-medium text-xs">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <span class="hidden md:inline text-sm">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div id="user-menu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden z-50">
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Admin Dashboard</a>
                                @elseif(Auth::user()->role === 'seller')
                                    <a href="{{ route('seller.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Seller Dashboard</a>
                                @else
                                    <a href="{{ route('buyer.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Buyer Dashboard</a>
                                @endif
                                <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Sign out
                                </a>
                            </div>
                            
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    @else
                        <!-- Guest User Options -->
                        <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="text-gray-700 hover:text-blue-600 font-medium text-sm transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="px-3 py-1 bg-blue-600 text-white rounded text-sm font-medium hover:bg-blue-700 transition-colors hidden md:inline">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header - Logo, Search, and Categories -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('welcome') }}" class="flex items-center">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mobile-logo">
                        <div class="text-white font-bold text-lg">T</div>
                    </div>
                    <span class="ml-3 text-2xl font-bold text-gray-800">Transamota</span>
                </a>
            </div>

            <!-- Search Bar -->
            <div class="flex-grow max-w-2xl mx-8 hidden md:block">
                <div class="relative">
                    <input type="text" placeholder="Search products, suppliers, categories..." 
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <button class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white p-1 rounded">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center space-x-4">
                @auth
                <a href="{{ route('favorites.index') }}" class="hidden md:flex items-center text-gray-700 hover:text-blue-600">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <span class="text-sm">Favorites</span>
                </a>
                <a href="{{ route('inquiries.index') }}" class="hidden md:flex items-center text-gray-700 hover:text-blue-600">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="text-sm">Inquiries</span>
                </a>
                @else
                <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="hidden md:flex items-center text-gray-700 hover:text-blue-600">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <span class="text-sm">Favorites</span>
                </a>
                <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="hidden md:flex items-center text-gray-700 hover:text-blue-600">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="text-sm">Inquiries</span>
                </a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" class="text-gray-700 hover:text-blue-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
                <button id="mobile-nav-button" class="text-gray-700 hover:text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Category Navigation Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 border-t border-gray-200">
        <div class="hidden md:flex overflow-x-auto py-3 hide-scrollbar">
            @if(isset($categories) && $categories->count() > 0)
                @foreach($categories as $category)
                <a href="{{ route('products.browse', ['category' => $category->id]) }}" 
                   class="flex-shrink-0 flex justify-center items-center px-4 py-2 text-sm {{ request('category') == $category->id ? 'text-blue-600 bg-blue-50 font-semibold' : 'text-gray-700 hover:text-blue-600 hover:bg-gray-50' }} rounded-lg transition-colors min-w-[100px]">
                    <span class="truncate font-semibold">{{ $category->name }}</span>
                </a>
                @endforeach
            @else
                <div class="flex items-center justify-center w-full py-2 text-gray-500">
                    <span>No categories available</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Mobile Search - Hidden on desktop -->
    <div class="md:hidden px-4 pb-3">
        <div class="relative">
            <input type="text" placeholder="Search products, suppliers, categories..." 
                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <button class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white p-1 rounded">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t border-gray-200">
            <a href="{{ route('welcome') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 {{ request()->routeIs('welcome') ? 'text-blue-600 bg-gray-50' : '' }}">Home</a>
            <a href="{{ route('products.browse') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Browse Products</a>
            <a href="{{ route('sell') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Sell on Transamota</a>
            <a href="{{ route('services') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Trade Services</a>
            <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Contact Us</a>
            <a href="{{ route('faq') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">FAQ</a>
            <a href="{{ route('safety-tips') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Safety Tips</a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Country/Region</a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Language</a>
            
            @auth
                <div class="pt-4 pb-2 border-t border-gray-200">
                    <div class="px-3 py-2 text-sm text-gray-700">Welcome, {{ Auth::user()->name }}!</div>
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Admin Dashboard</a>
                    @elseif(Auth::user()->role === 'seller')
                        <a href="{{ route('seller.dashboard') }}" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Seller Dashboard</a>
                    @else
                        <a href="{{ route('buyer.dashboard') }}" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Buyer Dashboard</a>
                    @endif
                    <a href="{{ route('favorites.index') }}" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">My Favorites</a>
                    <a href="{{ route('inquiries.index') }}" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">My Inquiries</a>
                    <a href="{{ route('logout') }}" class="block w-full text-left px-4 py-2 mt-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50"
                       onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();">
                        Sign out
                    </a>
                    <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            @else
                <div class="pt-4 pb-2 border-t border-gray-200">
                    <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="block w-full text-center px-4 py-2 text-base font-medium text-gray-700 hover:text-blue-600">Login</a>
                    <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2 mt-2 bg-blue-600 text-white rounded-lg text-base font-medium hover:bg-blue-700">Register</a>
                    <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="block w-full text-center px-4 py-2 mt-2 text-base font-medium text-gray-700 hover:text-blue-600">My Favorites</a>
                    <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="block w-full text-center px-4 py-2 mt-2 text-base font-medium text-gray-700 hover:text-blue-600">My Inquiries</a>
                </div>
            @endauth
        </div>
    </div>
</header>

<!-- We're using the external header.js file for JavaScript functionality -->