<!-- Buyer Header -->
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
                <span class="text-lg font-semibold text-gray-700">Buyer Dashboard</span>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex space-x-6">
                <a href="{{ route('products.browse') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Browse Products</a>
                <a href="{{ route('buyer.orders') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors {{ request()->routeIs('buyer.orders') ? 'text-blue-600' : '' }}">Orders</a>
                <a href="{{ route('buyer.inquiries') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors {{ request()->routeIs('buyer.inquiries') ? 'text-blue-600' : '' }}">Inquiries</a>
                <a href="{{ route('buyer.saved-products') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors {{ request()->routeIs('buyer.saved-products') ? 'text-blue-600' : '' }}">Saved Products</a>
                <a href="{{ route('faq') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">FAQ</a>
            </nav>

            <!-- User Menu -->
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <button id="user-menu-button" class="flex items-center space-x-2 text-gray-700 hover:text-blue-600">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 font-medium text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <span class="hidden md:inline text-sm font-medium">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div id="user-menu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden">
                        <a href="{{ route('products.browse') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Browse Products</a>
                        <a href="{{ route('buyer.profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile Settings</a>
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
        <a href="{{ route('buyer.reviews') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Reviews</a>
        <a href="{{ route('buyer.settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
        <a href="{{ route('faq') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">FAQ</a>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t border-gray-200">
            <a href="{{ route('products.browse') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Browse Products</a>
            <a href="{{ route('buyer.orders') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 {{ request()->routeIs('buyer.orders') ? 'text-blue-600 bg-gray-50' : '' }}">Orders</a>
            <a href="{{ route('buyer.inquiries') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 {{ request()->routeIs('buyer.inquiries') ? 'text-blue-600 bg-gray-50' : '' }}">Inquiries</a>
            <a href="{{ route('buyer.saved-products') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 {{ request()->routeIs('buyer.saved-products') ? 'text-blue-600 bg-gray-50' : '' }}">Saved Products</a>
            <a href="{{ route('products.browse') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Browse Products</a>
            
            <div class="pt-4 pb-2 border-t border-gray-200">
                <div class="px-3 py-2 text-sm text-gray-700">Welcome, {{ Auth::user()->name }}!</div>
                <a href="{{ route('buyer.profile.index') }}" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Profile Settings</a>
                <a href="{{ route('logout') }}" class="block w-full text-left px-4 py-2 mt-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50"
                   onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();">
                    Sign out
                </a>
                <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</header>