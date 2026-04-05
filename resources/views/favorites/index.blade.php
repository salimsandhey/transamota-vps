@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            @include('layouts.nav.content-header', [
                'title' => 'My Favorites',
                'subtitle' => 'Products you\'ve saved for later',
            ])

            <!-- Favorites List -->
            <div class="p-8">
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    @if($favorites->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($favorites as $favorite)
                                @php
                                    $product = $favorite->product;
                                    $primaryImage = $product->images->first();
                                @endphp
                                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                                    <div class="relative">
                                        @if($primaryImage)
                                            <img src="{{ asset('storage/' . $primaryImage->image_path) }}" alt="{{ $product->name }}" class="w-full h-48 object-contain">
                                        @else
                                            <div class="bg-gray-200 border-2 border-dashed rounded-xl w-full h-48 flex items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <button 
                                            data-product-id="{{ $product->id }}"
                                            class="favorite-btn absolute top-2 right-2 bg-white rounded-full p-2 shadow-md"
                                            title="Remove from favorites">
                                            <svg class="w-5 h-5 text-red-500 fill-current" viewBox="0 0 24 24">
                                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="p-4">
                                        <h3 class="font-medium text-gray-800 truncate">{{ $product->name }}</h3>
                                        <p class="text-sm text-gray-600 mt-1 truncate">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                        <div class="flex items-center justify-between mt-3">
                                            <span class="font-medium text-blue-600">₹{{ number_format($product->price, 2) }}</span>
                                            <a href="{{ route('products.show', $product) }}" class="text-sm text-blue-600 hover:text-blue-800">View Details</a>
                                        </div>
                                        <div class="mt-2 text-xs text-gray-500">
                                            By {{ $product->seller->company_name ?? $product->seller->name }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">No favorites yet</h3>
                            <p class="mt-1 text-gray-500">Start adding products to your favorites to see them here.</p>
                            <div class="mt-6">
                                <a href="{{ route('products.browse') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                                    Browse Products
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle favorite button clicks
    document.querySelectorAll('.favorite-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const productId = this.getAttribute('data-product-id');
            const button = this;
            
            fetch(`/products/${productId}/favorite`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            })
            .then(response => response.json())
            .then(data => {
                if (!data.favorited) {
                    // Remove the product card from the grid
                    button.closest('.border').remove();
                    
                    // Show message if no favorites left
                    if (document.querySelectorAll('.border').length === 0) {
                        location.reload();
                    }
                    
                    // Show success toast
                    if (typeof Toast !== 'undefined') {
                        Toast.show(data.message, 'success');
                    } else {
                        console.log(data.message); // Fallback
                    }
                } else {
                    // Show success toast for re-adding
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
                    console.log('An error occurred. Please try again.');
                }
            });
        });
    });
});
</script>
@endsection