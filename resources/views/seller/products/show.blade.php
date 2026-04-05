@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        @include('layouts.nav.seller-sidebar')

        <!-- Main Content -->
        <div id="main-content" class="flex-1 overflow-auto transition-all duration-300 ease-in-out md:ml-0">
            @include('layouts.nav.content-header', [
                'title' => 'Product Details',
                'subtitle' => 'View your product information',
                'headerActions' => view('seller.products.partials.edit-button', ['product' => $product])->render()
            ])

            <div class="p-8">
                <div class="bg-white rounded-xl border border-gray-200 p-6 max-w-4xl">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Product Images -->
                        <div class="lg:col-span-1">
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Product Images</h3>
                                <div class="grid grid-cols-2 gap-2">
                                    @forelse($product->images as $image)
                                        <div class="aspect-square">
                                            <img src="{{ \App\Helpers\ImageHelper::getImageUrl($image->image_path) }}" alt="Product image" class="w-full h-full object-cover rounded-lg">
                                        </div>
                                    @empty
                                        <div class="col-span-2 text-center py-4 text-gray-500">
                                            No images available
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        
                        <!-- Product Details -->
                        <div class="lg:col-span-2">
                            <h3 class="text-lg font-semibold text-gray-800 mb-6">Product Information</h3>
                            
                            <!-- Basic Information -->
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-700 mb-4">Basic Information</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Product Name</label>
                                        <p class="text-gray-800">{{ $product->name }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Origin Country</label>
                                        <p class="text-gray-800">{{ $product->origin_country ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Description</label>
                                    <p class="text-gray-800">{{ $product->description }}</p>
                                </div>
                            </div>
                            
                            <!-- Pricing & Inventory -->
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-700 mb-4">Pricing & Inventory</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Price</label>
                                        <p class="text-gray-800">₹{{ $product->price ? number_format($product->price, 2) : 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Minimum Order Quantity</label>
                                        <p class="text-gray-800">{{ $product->moq }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Unit</label>
                                        <p class="text-gray-800">{{ ucfirst($product->unit) }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Categories -->
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-700 mb-4">Categories</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Category</label>
                                        <p class="text-gray-800">{{ $product->category->name ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Subcategory</label>
                                        <p class="text-gray-800">{{ $product->subcategory->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Status Information -->
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-700 mb-4">Status Information</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Product Status</label>
                                        <span class="px-2 py-1 rounded text-xs 
                                            @if($product->status == 'active') bg-emerald-100 text-emerald-800
                                            @elseif($product->status == 'inactive') bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($product->status) }}
                                        </span>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Verification Status</label>
                                        <span class="px-2 py-1 rounded text-xs 
                                            @if($product->verification_status == 'approved') bg-emerald-100 text-emerald-800
                                            @elseif($product->verification_status == 'pending') bg-amber-100 text-amber-800
                                            @elseif($product->verification_status == 'rejected') bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($product->verification_status) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Display rejection reason if product is rejected -->
                                @if($product->verification_status == 'rejected' && $product->rejection_reason)
                                <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                                    <h4 class="text-sm font-medium text-red-800 mb-2">Rejection Reason</h4>
                                    <p class="text-sm text-red-700">{{ $product->rejection_reason }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection