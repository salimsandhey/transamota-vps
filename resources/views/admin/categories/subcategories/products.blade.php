@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        @include('layouts.nav.admin-sidebar')

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            @include('layouts.nav.content-header', [
                'title' => 'Products in ' . $subcategory->name,
                'subtitle' => 'View all products in this subcategory',
                'headerActions' => '<a href="' . route('admin.categories.subcategories.index', $category) . '" class="flex items-center gap-2 px-4 py-2 border border-gray-200 rounded-lg text-sm hover:bg-gray-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Subcategories
                </a>'
            ])

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mx-8 mt-6">
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div class="text-green-800 font-medium">{{ session('success') }}</div>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mx-8 mt-6">
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="text-red-800 font-medium">{{ session('error') }}</div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Products Table -->
            <div class="p-8">
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                        <h3 class="text-lg font-semibold text-gray-800">Products ({{ $products->total() }})</h3>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <form method="GET" class="flex gap-2">
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        name="search" 
                                        placeholder="Search products..." 
                                        value="{{ request('search') }}"
                                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full sm:w-64">
                                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    Filter
                                </button>
                                
                                @if(request()->has('search'))
                                    <a href="{{ route('admin.categories.subcategories.products', [$category, $subcategory]) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300">
                                        Clear
                                    </a>
                                @endif
                            </form>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left text-xs text-gray-500 border-b border-gray-200">
                                    <th class="pb-3 font-medium">Product</th>
                                    <th class="pb-3 font-medium">Seller</th>
                                    <th class="pb-3 font-medium">Price</th>
                                    <th class="pb-3 font-medium">Status</th>
                                    <th class="pb-3 font-medium text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($products as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-4">
                                        <div class="flex items-center gap-3">
                                            @if($product->primaryImage)
                                                <img src="/storage/{{ $product->primaryImage->image_path }}" alt="{{ $product->name }}" class="w-10 h-10 rounded-lg object-cover">
                                            @else
                                                <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <a href="{{ route('seller.products.show', $product) }}" class="font-medium text-gray-800 text-sm hover:text-blue-600">
                                                    {{ Str::limit($product->name, 25) }}
                                                </a>
                                                <div class="text-xs text-gray-500">{{ Str::limit($product->description, 30) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 text-sm text-gray-600">
                                        {{ $product->seller->name ?? 'N/A' }}
                                    </td>
                                    <td class="py-4 text-sm font-medium text-gray-800">
                                        @if($product->price)
                                            ${{ number_format($product->price, 2) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="py-4">
                                        <span class="px-2 py-1 rounded text-xs 
                                            @if($product->status == 'active') bg-emerald-100 text-emerald-800
                                            @elseif($product->status == 'pending') bg-amber-100 text-amber-800
                                            @elseif($product->status == 'inactive') bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($product->status) }}
                                        </span>
                                    </td>
                                    <td class="py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('seller.products.show', $product) }}" 
                                               class="text-gray-500 hover:text-gray-700" title="View Details">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('seller.products.edit', $product) }}" 
                                               class="text-gray-500 hover:text-gray-700" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-gray-500">
                                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                        <p>No products found in this subcategory</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if(method_exists($products, 'hasPages') && $products->hasPages())
                    <div class="flex items-center justify-between mt-6">
                        <div class="text-sm text-gray-600">
                            Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
                        </div>
                        <div class="mt-4">
                            {{ $products->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection