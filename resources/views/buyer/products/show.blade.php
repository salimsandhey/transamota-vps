@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        @include('layouts.nav.buyer-sidebar')

        <!-- Main Content -->
        <div id="main-content" class="flex-1 overflow-auto transition-all duration-300 ease-in-out">
            @include('layouts.nav.buyer-header')
            
            @include('layouts.nav.content-header', [
                'title' => 'Product Details',
                'subtitle' => 'View product information',
                'headerActions' => '<button class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    Save Product
                </button>'
            ])

            <!-- Product Details -->
            <div class="p-8">
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Product Images -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Product Images</h3>
                            @if($product->images->count() > 0)
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                    @foreach($product->images as $image)
                                        <div class="relative border rounded-lg overflow-hidden {{ $image->is_primary ? 'ring-2 ring-blue-500' : '' }}">
                                            <img src="{{ \App\Helpers\ImageHelper::getImageUrl($image->image_path) }}" alt="{{ $product->name }}" class="w-full h-32 object-cover">
                                            @if($image->is_primary)
                                                <div class="absolute top-2 left-2 bg-blue-600 text-white text-xs px-2 py-1 rounded">
                                                    Primary
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-gray-500">No images available</p>
                                </div>
                            @endif
                        </div>

                        <!-- Product Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Product Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Product Name</label>
                                    <div class="mt-1 text-sm text-gray-900">{{ $product->name }}</div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Description</label>
                                    <div class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ $product->description }}</div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Category</label>
                                        <div class="mt-1 text-sm text-gray-900">{{ $product->category->name ?? 'N/A' }}</div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Subcategory</label>
                                        <div class="mt-1 text-sm text-gray-900">{{ $product->subcategory->name ?? 'N/A' }}</div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Price</label>
                                        <div class="mt-1 text-sm text-gray-900">
                                            @if($product->price)
                                                ₹{{ number_format($product->price, 2) }}
                                            @else
                                                Price on request
                                            @endif
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Minimum Order Quantity</label>
                                        <div class="mt-1 text-sm text-gray-900">{{ $product->moq }} {{ $product->unit }}</div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Origin Country</label>
                                        <div class="mt-1 text-sm text-gray-900">{{ $product->origin_country }}</div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Status</label>
                                        <div class="mt-1">
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

                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Seller</label>
                                    <div class="mt-1 text-sm text-gray-900">{{ $product->seller->company_name ?? $product->seller->name ?? 'Unknown Seller' }}</div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row gap-3 mt-6">
                                <button class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    Contact Seller
                                </button>
                                <button class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Add to Inquiry
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('products.browse') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                            Back to Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection