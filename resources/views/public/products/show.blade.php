@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Breadcrumb -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex text-sm" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li>
                        <a href="{{ route('welcome') }}" class="text-gray-500 hover:text-blue-600">Home</a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </li>
                    <li>
                        <a href="{{ route('products.browse') }}" class="text-gray-500 hover:text-blue-600">Products</a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </li>
                    <li class="text-gray-900 truncate max-w-xs">{{ $product->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Product Gallery and Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6">
                <!-- Product Gallery -->
                <div>
                    <div class="mb-4">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h2>
                    </div>

                    <!-- Image Gallery -->
                    <div class="mb-6">
                        @if($product->images->count() > 0)
                            <!-- Main Image -->
                            <div class="relative mb-4">
                                <img id="main-image" src="{{ \App\Helpers\ImageHelper::getImageUrl($product->images->first()->image_path) }}" alt="{{ $product->name }}" class="w-full h-96 object-contain bg-white rounded-lg p-2">
                                @if(auth()->check())
                                <button 
                                    data-product-id="{{ $product->id }}"
                                    class="favorite-btn absolute top-4 right-4 bg-white rounded-full p-3 shadow-md"
                                    title="{{ auth()->user()->favorites()->where('product_id', $product->id)->exists() ? 'Remove from favorites' : 'Add to favorites' }}">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path class="{{ auth()->user()->favorites()->where('product_id', $product->id)->exists() ? 'text-red-500 fill-current' : 'text-gray-400 fill-current border border-red-500' }}" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                </button>
                                @endif
                            </div>

                            <!-- Thumbnail Images -->
                            <div class="flex space-x-3 overflow-x-auto pb-2">
                                @foreach($product->images as $index => $image)
                                    <div class="flex-shrink-0">
                                        <img src="{{ \App\Helpers\ImageHelper::getImageUrl($image->image_path) }}" alt="{{ $product->name }}" 
                                             class="w-20 h-20 object-cover rounded cursor-pointer border-2 {{ $index === 0 ? 'border-blue-500' : 'border-gray-200' }} hover:border-blue-300"
                                             onclick="changeMainImage('{{ \App\Helpers\ImageHelper::getImageUrl($image->image_path) }}')">
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-12 text-center">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-gray-500">No images available</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Information -->
                <div>
                    <div class="border-b border-gray-200 pb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Price</h3>
                                <p class="text-3xl font-bold text-gray-900 mt-1">
                                    @if($product->price)
                                        ₹{{ number_format($product->price, 2) }}
                                    @else
                                        <span class="text-lg">Price on request</span>
                                    @endif
                                </p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-500">MOQ</div>
                                <div class="text-lg font-medium text-gray-900">{{ $product->moq }} {{ $product->unit }}</div>
                            </div>
                        </div>
                        
                        @if($product->origin_country)
                        <div class="mt-4">
                            <div class="text-sm text-gray-500">Origin</div>
                            <div class="flex items-center mt-1">
                                <svg class="w-5 h-5 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-gray-900">{{ $product->origin_country }}</span>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="border-b border-gray-200 py-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Description</h3>
                        <div class="prose prose-sm text-gray-600">
                            <p>{{ $product->description }}</p>
                        </div>
                    </div>

                    <div class="py-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Product Details</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <div class="text-sm text-gray-500">Category</div>
                                <div class="text-gray-900">{{ $product->category->name ?? 'N/A' }}</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500">Subcategory</div>
                                <div class="text-gray-900">{{ $product->subcategory->name ?? 'N/A' }}</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500">Status</div>
                                <div>
                                    <span class="px-2 py-1 rounded text-xs 
                                        @if($product->status == 'active') bg-emerald-100 text-emerald-800
                                        @elseif($product->status == 'pending') bg-amber-100 text-amber-800
                                        @elseif($product->status == 'inactive') bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-4">
                        @if(auth()->check())
                            @if(auth()->user()->role === 'buyer')
                                <button id="chat-with-seller" data-seller-id="{{ $product->seller->id }}" data-product-id="{{ $product->id }}" class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center justify-center gap-2 font-medium">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    Chat with Seller
                                </button>
                                <button id="add-to-inquiry" data-product-id="{{ $product->id }}" class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 flex items-center justify-center gap-2 font-medium">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    Add to Inquiry
                                </button>
                            @else
                                <div class="text-gray-500 text-center py-3">
                                    Only buyers can contact sellers or make inquiries
                                </div>
                            @endif
                        @else
                            <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center justify-center gap-2 font-medium">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Login to Contact Seller
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Seller and Product Details -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Seller Information -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Seller Information</h3>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-bold text-xl">{{ substr($product->seller->company_name ?? $product->seller->name ?? 'S', 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-medium text-gray-900">{{ $product->seller->company_name ?? $product->seller->name ?? 'Unknown Seller' }}</h4>
                            @if($product->seller->is_verified)
                                <div class="flex items-center mt-1">
                                    <span class="inline-flex items-center text-blue-600 bg-blue-50 px-2 py-1 rounded text-xs">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Verified Seller
                                    </span>
                                </div>
                            @endif
                            @if($product->origin_country)
                                <div class="flex items-center mt-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>From {{ $product->origin_country }}</span>
                                </div>
                            @endif
                            <div class="mt-3 text-sm text-gray-600">
                                <span class="font-medium text-gray-900">{{ $sellerProductCount ?? 0 }}</span> products listed
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="#" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                            View Seller Profile
                        </a>
                    </div>
                </div>
            </div>

            <!-- Product Specifications - REMOVED AS PER REQUEST -->
        </div>

        <!-- Related Products -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Related Products</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @if($relatedProducts->count() > 0)
                    @foreach($relatedProducts as $relatedProduct)
                    <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                        <div class="h-48 bg-gray-100 relative">
                            @if($relatedProduct->images->first())
                                <img src="{{ \App\Helpers\ImageHelper::getImageUrl($relatedProduct->images->first()->image_path) }}" alt="{{ $relatedProduct->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="bg-gray-200 border-2 border-dashed rounded-xl w-full h-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            @if(auth()->check())
                            <button 
                                data-product-id="{{ $relatedProduct->id }}"
                                class="favorite-btn absolute top-2 right-2 bg-white rounded-full p-2 shadow-md hover:bg-gray-50"
                                title="{{ auth()->user()->favorites()->where('product_id', $relatedProduct->id)->exists() ? 'Remove from favorites' : 'Add to favorites' }}">
                                <svg class="w-5 h-5" viewBox="0 0 24 24">
                                    <path class="{{ auth()->user()->favorites()->where('product_id', $relatedProduct->id)->exists() ? 'text-red-500 fill-current' : 'text-gray-400 fill-current border border-red-500' }}" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                            </button>
                            @endif
                        </div>
                        <div class="p-4">
                            <h4 class="font-medium text-gray-800 mb-1 truncate">{{ $relatedProduct->name }}</h4>
                            <div class="flex items-center justify-between mt-2">
                                <span class="font-semibold text-gray-900">
                                    @if($relatedProduct->price)
                                        ₹{{ number_format($relatedProduct->price, 2) }}
                                    @else
                                        Price on request
                                    @endif
                                </span>
                                <a href="{{ route('products.show', $relatedProduct->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-span-full text-center py-8">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <p class="text-gray-500">No related products found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
// Function to change main image when thumbnail is clicked
function changeMainImage(src) {
    document.getElementById('main-image').src = src;
}

document.addEventListener('DOMContentLoaded', function() {
    // Handle favorite button click for main product
    const favoriteButton = document.querySelector('.favorite-btn');
    
    if (favoriteButton) {
        favoriteButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            
            // Disable the button temporarily to prevent double clicks
            const originalButton = this;
            originalButton.disabled = true;
            
            const productId = this.getAttribute('data-product-id');
            
            fetch(`/products/${productId}/favorite`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            })
            .then(response => response.json())
            .then(data => {
                const svgPath = this.querySelector('svg path');
                
                // Reset all classes
                svgPath.classList.remove('text-white', 'text-gray-400', 'text-red-500', 'fill-current', 'border', 'border-red-500');
                
                if (data.favorited) {
                    // Set favorited state (red heart)
                    svgPath.classList.add('text-red-500', 'fill-current');
                    this.title = 'Remove from favorites';
                    // Show success toast
                    if (typeof Toast !== 'undefined') {
                        Toast.show(data.message, 'success');
                    } else {
                        console.log(data.message); // Fallback
                    }
                } else {
                    // Set unfavorited state (gray heart with red border)
                    svgPath.classList.add('text-gray-400', 'fill-current', 'border', 'border-red-500');
                    this.title = 'Add to favorites';
                    // Show success toast
                    if (typeof Toast !== 'undefined') {
                        Toast.show(data.message, 'success');
                    } else {
                        console.log(data.message); // Fallback
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (typeof Toast !== 'undefined') {
                    Toast.show('An error occurred. Please try again.', 'error');
                } else {
                    alert('An error occurred. Please try again.');
                }
            })
            .finally(() => {
                // Re-enable the button
                originalButton.disabled = false;
            });
        });
    }
    
    // Handle favorite button clicks for related products
    document.querySelectorAll('.favorite-btn').forEach(button => {
        // Skip if already attached event listener (main product button)
        if (button === favoriteButton) return;
        
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            
            // Disable the button temporarily to prevent double clicks
            const originalButton = this;
            originalButton.disabled = true;
            
            const productId = this.getAttribute('data-product-id');
            
            fetch(`/products/${productId}/favorite`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            })
            .then(response => response.json())
            .then(data => {
                const svgPath = this.querySelector('svg path');
                
                // Reset all classes
                svgPath.classList.remove('text-white', 'text-gray-400', 'text-red-500', 'fill-current', 'border', 'border-red-500');
                
                if (data.favorited) {
                    // Set favorited state (red heart)
                    svgPath.classList.add('text-red-500', 'fill-current');
                    this.title = 'Remove from favorites';
                    // Show success toast
                    if (typeof Toast !== 'undefined') {
                        Toast.show(data.message, 'success');
                    } else {
                        console.log(data.message); // Fallback
                    }
                } else {
                    // Set unfavorited state (gray heart with red border)
                    svgPath.classList.add('text-gray-400', 'fill-current', 'border', 'border-red-500');
                    this.title = 'Add to favorites';
                    // Show success toast
                    if (typeof Toast !== 'undefined') {
                        Toast.show(data.message, 'success');
                    } else {
                        console.log(data.message); // Fallback
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (typeof Toast !== 'undefined') {
                    Toast.show('An error occurred. Please try again.', 'error');
                } else {
                    alert('An error occurred. Please try again.');
                }
            })
            .finally(() => {
                // Re-enable the button
                originalButton.disabled = false;
            });
        });
    });
    
    // Handle "Add to Inquiry" button click
    const addToInquiryButton = document.getElementById('add-to-inquiry');
    
    if (addToInquiryButton) {
        addToInquiryButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Disable the button temporarily to prevent double clicks
            const originalButton = this;
            originalButton.disabled = true;
            
            const productId = this.getAttribute('data-product-id');
            
            fetch(`/inquiries/add`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    // Show success message
                    alert('Product added to inquiries successfully!');
                    
                    // Optionally redirect to inquiries page
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            })
            .finally(() => {
                // Re-enable the button
                originalButton.disabled = false;
            });
        });
    }
    
    // Handle "Chat with Seller" button click
    const chatWithSellerButton = document.getElementById('chat-with-seller');
    
    if (chatWithSellerButton) {
        chatWithSellerButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            const sellerId = this.getAttribute('data-seller-id');
            const productId = this.getAttribute('data-product-id');
            
            fetch(`/chat/conversation`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    seller_id: sellerId,
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else if (data.redirect_url) {
                    window.location.href = data.redirect_url;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
    }
});
</script>
@endsection