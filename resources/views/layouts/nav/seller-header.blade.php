<!-- Seller Header -->
<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Mobile Sidebar Toggle Button -->
            <div class="md:hidden flex items-center">
                <button id="mobile-sidebar-toggle" class="text-gray-700 hover:text-blue-600 p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Logo/Title -->
            <div class="flex items-center">
                <span class="text-lg font-semibold text-gray-700">Seller Dashboard</span>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex space-x-6">
                <a href="{{ route('products.browse') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Browse Products</a>
                <a href="{{ route('seller.orders') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors {{ request()->routeIs('seller.orders') ? 'text-blue-600' : '' }}">Orders</a>
                <a href="{{ route('seller.inquiries') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors {{ request()->routeIs('seller.inquiries') ? 'text-blue-600' : '' }}">Inquiries</a>
                <a href="{{ route('favorites.index') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Favorites</a>
                <a href="{{ route('seller.customers') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors {{ request()->routeIs('seller.customers') ? 'text-blue-600' : '' }}">Customers</a>
                <a href="{{ route('faq') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">FAQ</a>
            </nav>

            <!-- User Menu -->
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <button id="user-menu-button" class="flex items-center space-x-2 text-gray-700 hover:text-blue-600">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <span class="text-green-600 font-medium text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <span class="hidden md:inline text-sm font-medium">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div id="user-menu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden">
                        <a href="{{ route('products.browse') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Browse Products</a>
                        <a href="{{ route('seller.products') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Products</a>
                        <a href="{{ route('favorites.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Favorites</a>
                        <a href="{{ route('seller.profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                        <a href="{{ route('seller.settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                        <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Sign out
                        </a>
                    </div>
                    
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            </div>

            <!-- Mobile menu buttons -->
            <div class="md:hidden flex items-center space-x-2">
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

    <!-- Additional Mobile Menu -->
    <div id="mobile-additional-menu" class="md:hidden hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
        <a href="{{ route('products.browse') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Browse Products</a>
        <a href="{{ route('seller.analytics') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Analytics</a>
        <a href="{{ route('seller.payments') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Payments</a>
        <a href="{{ route('favorites.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Favorites</a>
        <a href="{{ route('seller.profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
        <a href="{{ route('faq') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">FAQ</a>
    </div>
</header>