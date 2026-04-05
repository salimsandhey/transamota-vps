@extends('layouts.app')

@section('title', 'Transamota - Global B2B Trade Platform')

@section('content')
<!-- Main content with proper spacing to avoid header overlap -->
<div class="flex flex-col min-h-screen">
    <!-- Simplified Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white pt-8 pb-16" style="background: linear-gradient(to top, #00000088), url('/images/hero-bg-image.jpg'); background-size: cover; background-position: center;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-3xl md:text-5xl font-bold mb-6">Global B2B Trade Platform</h1>
                <p class="text-xl md:text-2xl mb-2 max-w-3xl mx-auto">Connect with verified suppliers and buyers worldwide</p>
                <p class="text-lg md:text-xl text-blue-100 max-w-2xl mx-auto">Expand your business across international markets</p>
            </div>
            
            <!-- Stats and CTA Section -->
            <div class="max-w-5xl mx-auto mb-12">
                <div class="bg-white bg-opacity-10 rounded-xl p-6 backdrop-blur-sm" style="background-color: rgba(255, 255, 255, 0.1);">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                        <div>
                            <div class="text-2xl md:text-3xl font-bold">10K+</div>
                            <div class="text-blue-100">Verified Suppliers</div>
                        </div>
                        <div>
                            <div class="text-2xl md:text-3xl font-bold">150+</div>
                            <div class="text-blue-100">Countries</div>
                        </div>
                        <div>
                            <div class="text-2xl md:text-3xl font-bold">50K+</div>
                            <div class="text-blue-100">Products</div>
                        </div>
                        <div>
                            <div class="text-2xl md:text-3xl font-bold">1M+</div>
                            <div class="text-blue-100">Transactions</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Platform Features -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-6 max-w-6xl mx-auto">
                <div class="bg-white bg-opacity-10 rounded-lg p-5 backdrop-blur-sm hover:bg-opacity-20 transition-all" style="background-color: rgba(255, 255, 255, 0.1);">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4" style="background-color: rgba(255, 255, 255, 0.2);">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Sell Globally</h3>
                    <p class="text-blue-100 text-sm">Reach international buyers and expand your business worldwide</p>
                </div>
                
                <div class="bg-white bg-opacity-10 rounded-lg p-5 backdrop-blur-sm hover:bg-opacity-20 transition-all" style="background-color: rgba(255, 255, 255, 0.1);">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4" style="background-color: rgba(255, 255, 255, 0.2);">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Import & Export</h3>
                    <p class="text-blue-100 text-sm">Find reliable suppliers and buyers for your trade needs</p>
                </div>
                
                <div class="bg-white bg-opacity-10 rounded-lg p-5 backdrop-blur-sm hover:bg-opacity-20 transition-all" style="background-color: rgba(255, 255, 255, 0.1);">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4" style="background-color: rgba(255, 255, 255, 0.2);">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Verified Suppliers</h3>
                    <p class="text-blue-100 text-sm">Trade with pre-verified suppliers for secure transactions</p>
                </div>
                
                <div class="bg-white bg-opacity-10 rounded-lg p-5 backdrop-blur-sm hover:bg-opacity-20 transition-all" style="background-color: rgba(255, 255, 255, 0.1);">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4" style="background-color: rgba(255, 255, 255, 0.2);">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Trade Services</h3>
                    <p class="text-blue-100 text-sm">Access logistics, financing, and customs support</p>
                </div>
            </div>
            
            <!-- CTA Buttons -->
            <div class="mt-12 text-center">
                @guest
                    <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-white text-blue-600 rounded-lg font-bold text-lg hover:bg-gray-100 transition-colors mr-4">
                        Start Selling
                    </a>
                    <a href="{{ route('products.browse') }}" class="inline-block px-8 py-4 bg-transparent border-2 border-white text-white rounded-lg font-bold text-lg hover:bg-white hover:text-blue-600 transition-colors">
                        Browse Products
                    </a>
                @else
                    @if(Auth::user()->role === 'buyer')
                        <a href="{{ route('products.browse') }}" class="inline-block px-8 py-4 bg-white text-blue-600 rounded-lg font-bold text-lg hover:bg-gray-100 transition-colors mr-4">
                            Browse Products
                        </a>
                        <a href="{{ route('favorites.index') }}" class="inline-block px-8 py-4 bg-transparent border-2 border-white text-white rounded-lg font-bold text-lg hover:bg-white hover:text-blue-600 transition-colors">
                            My Favorites
                        </a>
                    @elseif(Auth::user()->role === 'seller')
                        <a href="{{ route('seller.products') }}" class="inline-block px-8 py-4 bg-white text-blue-600 rounded-lg font-bold text-lg hover:bg-gray-100 transition-colors mr-4">
                            My Products
                        </a>
                        <a href="{{ route('seller.products.create') }}" class="inline-block px-8 py-4 bg-transparent border-2 border-white text-white rounded-lg font-bold text-lg hover:bg-white hover:text-blue-600 transition-colors">
                            Add New Product
                        </a>
                    @elseif(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="inline-block px-8 py-4 bg-white text-blue-600 rounded-lg font-bold text-lg hover:bg-gray-100 transition-colors mr-4">
                            Admin Dashboard
                        </a>
                        <a href="{{ route('products.browse') }}" class="inline-block px-8 py-4 bg-transparent border-2 border-white text-white rounded-lg font-bold text-lg hover:bg-white hover:text-blue-600 transition-colors">
                            Browse Products
                        </a>
                    @endif
                @endguest
            </div>
        </div>
    </section>

    <!-- Quick Categories -->
    <section class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-900">Browse Categories</h2>
                <div class="flex space-x-2">
                    <button id="quick-category-slider-prev" class="p-2 rounded-full bg-white shadow-sm hover:bg-gray-100 hidden">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button id="quick-category-slider-next" class="p-2 rounded-full bg-white shadow-sm hover:bg-gray-100 hidden">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div id="quick-category-slider" class="relative">
                <div class="flex overflow-x-auto pb-4 space-x-4 hide-scrollbar">
                    @if($categories->count() > 0)
                        @foreach($categories as $category)
                        <div class="flex-shrink-0 bg-white rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow text-center min-w-[120px] cursor-pointer category-item" data-category="{{ $category->id }}">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                @if($category->icon)
                                    {!! $category->icon !!}
                                @else
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                    </svg>
                                @endif
                            </div>
                            <h3 class="font-medium text-gray-900 text-sm">{{ $category->name }}</h3>
                        </div>
                        @endforeach
                    @else
                    <div class="col-span-full text-center py-4">
                        <p class="text-gray-500">No categories available at the moment.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Products -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Latest Products</h2>
                <a href="{{ route('products.browse') }}" class="text-blue-600 font-medium hover:text-blue-800">View All →</a>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @if($products->count() > 0)
                    @foreach($products as $product)
                    <a href="{{ route('products.show', $product->id) }}" class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-md transition-shadow block">
                        <div class="bg-white h-32 flex items-center justify-center">
                            @if($product->primaryImage)
                                <img src="/storage/{{ $product->primaryImage->image_path }}" alt="{{ $product->name }}" class="w-full h-full object-contain p-2">
                            @else
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="p-3">
                            <h3 class="font-medium text-gray-900 text-sm mb-1 truncate">{{ $product->name }}</h3>
                            <p class="text-blue-600 font-bold text-sm">₹{{ number_format($product->price, 2) }}</p>
                            <p class="text-gray-500 text-xs">{{ $product->category->name ?? 'Category' }} • {{ $product->created_at->diffForHumans() }}</p>
                        </div>
                    </a>
                    @endforeach
                @else
                <div class="col-span-full text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No products available</h3>
                    <p class="text-gray-500">There are currently no products listed on our platform.</p>
                </div>
                @endif
            </div>
        </div>
    </section>

    
    <script>
        // Category selection functionality
        document.querySelectorAll('.category-item').forEach(item => {
            item.addEventListener('click', function() {
                const categoryId = this.getAttribute('data-category');
                // Redirect to products browse page with category filter
                window.location.href = `/products/browse?category=${categoryId}`;
            });
        });
        
        // Quick category slider functionality
        document.addEventListener('DOMContentLoaded', function() {
            const quickCategorySlider = document.getElementById('quick-category-slider');
            const prevButton = document.getElementById('quick-category-slider-prev');
            const nextButton = document.getElementById('quick-category-slider-next');
            
            if (quickCategorySlider && prevButton && nextButton) {
                const sliderContainer = quickCategorySlider.querySelector('.flex');
                
                // Show/hide navigation buttons based on scroll position
                function updateNavigationButtons() {
                    const scrollLeft = sliderContainer.scrollLeft;
                    const scrollWidth = sliderContainer.scrollWidth;
                    const clientWidth = sliderContainer.clientWidth;
                    
                    // Show prev button if scrolled right
                    prevButton.classList.toggle('hidden', scrollLeft <= 0);
                    
                    // Show next button if can scroll more
                    nextButton.classList.toggle('hidden', scrollLeft + clientWidth >= scrollWidth);
                }
                
                // Scroll slider
                function scrollSlider(direction) {
                    const scrollAmount = 200;
                    sliderContainer.scrollBy({
                        left: direction === 'next' ? scrollAmount : -scrollAmount,
                        behavior: 'smooth'
                    });
                }
                
                // Event listeners
                prevButton.addEventListener('click', () => scrollSlider('prev'));
                nextButton.addEventListener('click', () => scrollSlider('next'));
                
                sliderContainer.addEventListener('scroll', updateNavigationButtons);
                
                // Initial check
                updateNavigationButtons();
                
                // Check on window resize
                window.addEventListener('resize', updateNavigationButtons);
            }
        });
    </script>
</div>
@endsection