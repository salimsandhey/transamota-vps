@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        @include('layouts.nav.seller-sidebar')

        <!-- Main Content -->
        <div id="main-content" class="flex-1 overflow-auto overflow-hidden transition-all duration-300 ease-in-out md:ml-0">
            @include('layouts.nav.content-header', [
                'title' => 'My Products',
                'subtitle' => 'Manage your product listings',
                'headerActions' => '<a href="' . route('seller.products.create') . '" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Product
                </a>'
            ])

            <!-- Success Message -->
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

            <!-- Error Message -->
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

            <!-- Product Listing -->
            <div class="p-8">
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                        <h3 class="text-lg font-semibold text-gray-800">Product List</h3>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <div class="relative">
                                <input type="text" placeholder="Search products..." 
                                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full sm:w-64">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option>All Statuses</option>
                                <option>Active</option>
                                <option>Pending</option>
                                <option>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left text-xs text-gray-500 border-b border-gray-200">
                                    <th class="pb-3 font-medium">Product</th>
                                    <th class="pb-3 font-medium">Category</th>
                                    <th class="pb-3 font-medium">Price</th>
                                    <th class="pb-3 font-medium">MOQ</th>
                                    <th class="pb-3 font-medium">Status</th>
                                    <th class="pb-3 font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($products as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-4">
                                        <div class="flex items-center gap-3">
                                            @if($product->primaryImage)
                                                <img src="{{ \App\Helpers\ImageHelper::getImageUrl($product->primaryImage->image_path) }}" alt="{{ $product->name }}" class="w-10 h-10 rounded-lg object-cover">
                                            @else
                                                <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <a href="{{ route('seller.products.show', $product->id) }}" class="font-medium text-gray-800 text-sm hover:text-blue-600">
                                                    {{ Str::limit($product->name, 25) }}
                                                </a>
                                                <div class="text-xs text-gray-500">{{ Str::limit($product->description, 30) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 text-sm text-gray-600">
                                        {{ $product->category->name ?? 'N/A' }}
                                        @if($product->subcategory)
                                            <div class="text-xs text-gray-500">{{ $product->subcategory->name }}</div>
                                        @endif
                                    </td>
                                    <td class="py-4 text-sm font-medium text-gray-800">
                                        @if($product->price)
                                            ₹{{ number_format($product->price, 2) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="py-4 text-sm text-gray-600">{{ $product->moq }} {{ $product->unit }}</td>
                                    <td class="py-4">
                                        <div class="flex flex-col">
                                            <span class="px-2 py-1 rounded text-xs 
                                                @if($product->status == 'active') bg-emerald-100 text-emerald-800
                                                @elseif($product->status == 'inactive') bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst($product->status) }}
                                            </span>
                                            <span class="text-xs mt-1
                                                @if($product->verification_status == 'approved') text-green-600
                                                @elseif($product->verification_status == 'pending') text-amber-600
                                                @elseif($product->verification_status == 'rejected') text-red-600
                                                @endif">
                                                Verification: {{ ucfirst($product->verification_status) }}
                                            </span>
                                            <!-- Display rejection reason icon if product is rejected -->
                                            @if($product->verification_status == 'rejected' && $product->rejection_reason)
                                            <span class="text-xs mt-1 text-red-600 flex items-center" title="{{ $product->rejection_reason }}">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Reason provided
                                            </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('seller.products.show', $product->id) }}" class="text-gray-500 hover:text-gray-700" title="View Details">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            <!-- Only allow editing if product is approved -->
                                            @if($product->verification_status == 'approved')
                                            <a href="{{ route('seller.products.edit', $product->id) }}" class="text-gray-500 hover:text-gray-700" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            @else
                                            <span class="text-gray-300 cursor-not-allowed" title="Product must be approved by admin to edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </span>
                                            @endif
                                            <div class="relative inline-block">
                                                <button class="text-gray-500 hover:text-gray-700 status-dropdown-toggle" data-product-id="{{ $product->id }}">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                                                    </svg>
                                                </button>
                                                <div class="status-dropdown absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden z-10">
                                                    <!-- Show status toggle only for approved products -->
                                                    @if($product->verification_status == 'approved')
                                                        @if($product->status == 'active')
                                                            <button class="toggle-status block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" data-product-id="{{ $product->id }}" data-status="inactive">
                                                                Set Inactive
                                                            </button>
                                                        @else
                                                            <button class="toggle-status block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" data-product-id="{{ $product->id }}" data-status="active">
                                                                Set Active
                                                            </button>
                                                        @endif
                                                    @endif
                                                    <!-- Only allow deletion if product is approved -->
                                                    @if($product->verification_status == 'approved')
                                                    <button class="delete-product block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}">
                                                        Delete Product
                                                    </button>
                                                    @else
                                                    <button class="block w-full text-left px-4 py-2 text-sm text-gray-400 cursor-not-allowed" title="Product must be approved by admin to delete">
                                                        Delete Product
                                                    </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-gray-500">
                                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                        <p>No products found. <a href="{{ route('seller.products.create') }}" class="text-blue-600 hover:text-blue-800">Add your first product</a></p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection