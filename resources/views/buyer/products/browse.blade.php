@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        @include('layouts.nav.buyer-sidebar')

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            @include('layouts.nav.content-header', [
                'title' => 'Browse Products',
                'subtitle' => 'Discover products from verified sellers',
            ])

            <!-- Filters -->
            <div class="px-8 py-6 border-b border-gray-200 bg-white">
                <form method="GET" action="{{ route('products.browse') }}" class="flex flex-wrap items-center gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div class="w-48">
                        <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="w-32">
                        <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Sort By</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Filter
                    </button>
                    
                    @if(request()->anyFilled(['search', 'category', 'sort']))
                        <a href="{{ route('products.browse') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            Clear
                        </a>
                    @endif
                </form>
            </div>

            <!-- Products Grid -->
            <div class="p-8">
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    @if($products->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach($products as $product)
                                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                                    <div class="relative">
                                        @if($product->primaryImage)
                                            <img src="{{ \App\Helpers\ImageHelper::getImageUrl($product->primaryImage->image_path) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                                        @else
                                            <div class="bg-gray-200 border-2 border-dashed rounded-xl w-full h-48 flex items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        
                                        @if($product->seller->is_verified)
                                            <span class="absolute top-2 left-2 bg-blue-500 text-white text-xs px-2 py-1 rounded-full flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                Verified
                                            </span>
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <h4 class="font-medium text-gray-800 mb-1">{{ Str::limit($product->name, 30) }}</h4>
                                        <p class="text-sm text-gray-500 mb-2">{{ Str::limit($product->description, 50) }}</p>
                                        <div class="flex items-center justify-between">
                                            <span class="font-semibold text-gray-900">
                                                @if($product->price)
                                                    ₹{{ number_format($product->price, 2) }}
                                                @else
                                                    Price on request
                                                @endif
                                            </span>
                                            <a href="{{ route('products.show', $product->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        @if($products->hasPages())
                        <div class="mt-8">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-1">No products found</h3>
                            <p class="text-gray-500">Try adjusting your search or filter criteria.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection