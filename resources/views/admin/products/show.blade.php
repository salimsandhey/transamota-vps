@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        @include('layouts.nav.admin-sidebar')

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            @include('layouts.nav.content-header', [
                'title' => 'Product Details',
                'subtitle' => 'View detailed information about this product',
                'headerActions' => '<a href="' . route('admin.products.index') . '" class="flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded-lg text-sm hover:bg-gray-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Products
                </a>'
            ])

            <div class="p-8">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <div class="p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <!-- Product Images -->
                            <div class="lg:col-span-1">
                                <div class="mb-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Product Images</h3>
                                    <div class="grid grid-cols-2 gap-4">
                                        @forelse($product->images as $image)
                                            <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden {{ $image->is_primary ? 'ring-2 ring-blue-500' : '' }}">
                                                <img src="{{ \App\Helpers\ImageHelper::getImageUrl($image->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                                @if($image->is_primary)
                                                    <div class="text-xs text-center text-blue-600 mt-1">Primary</div>
                                                @endif
                                            </div>
                                        @empty
                                            <div class="col-span-2 aspect-square bg-gray-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                                
                                <!-- Approval Actions -->
                                @if($product->verification_status === 'pending')
                                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-3">Verification Actions</h3>
                                    <div class="flex space-x-3">
                                        <form action="{{ route('admin.products.verify', $product) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                                Verify Product
                                            </button>
                                        </form>
                                        
                                        <!-- Reject button that opens modal -->
                                        <button type="button" 
                                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                                                onclick="openRejectModal({{ $product->id }})">
                                            Reject Product
                                        </button>
                                    </div>
                                </div>
                                @endif
                                
                                <!-- Rejection Reason Display -->
                                @if($product->verification_status === 'rejected' && $product->rejection_reason)
                                <div class="bg-red-50 rounded-lg p-4 mb-6">
                                    <h3 class="text-lg font-medium text-red-900 mb-2">Rejection Reason</h3>
                                    <p class="text-red-800">{{ $product->rejection_reason }}</p>
                                </div>
                                @endif
                            </div>
                            
                            <!-- Product Details -->
                            <div class="lg:col-span-2">
                                <div class="mb-6">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h1 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h1>
                                            <div class="mt-1 flex items-center">
                                                @php
                                                    $verificationStatusColors = [
                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                        'approved' => 'bg-green-100 text-green-800',
                                                        'rejected' => 'bg-red-100 text-red-800'
                                                    ];
                                                    $statusColors = [
                                                        'active' => 'bg-blue-100 text-blue-800',
                                                        'inactive' => 'bg-gray-100 text-gray-800'
                                                    ];
                                                @endphp
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $verificationStatusColors[$product->verification_status] ?? 'bg-gray-100 text-gray-800' }}">
                                                    Verification: {{ ucfirst($product->verification_status) }}
                                                </span>
                                                <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$product->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                    Visibility: {{ ucfirst($product->status) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.products.edit', $product) }}" class="px-3 py-1 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded-md text-sm hover:bg-red-700">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <p class="mt-4 text-gray-600">{{ $product->description }}</p>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <h3 class="text-lg font-medium text-gray-900 mb-3">Pricing & Details</h3>
                                        <div class="space-y-2">
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Price:</span>
                                                <span class="font-medium">${{ number_format($product->price, 2) }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Minimum Order Quantity:</span>
                                                <span class="font-medium">{{ $product->moq }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Unit:</span>
                                                <span class="font-medium">{{ $product->unit }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Origin Country:</span>
                                                <span class="font-medium">{{ $product->origin_country }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <h3 class="text-lg font-medium text-gray-900 mb-3">Category Information</h3>
                                        <div class="space-y-2">
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Category:</span>
                                                <span class="font-medium">{{ $product->category->name ?? 'N/A' }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Subcategory:</span>
                                                <span class="font-medium">{{ $product->subcategory->name ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-lg font-medium text-gray-900 mb-3">Seller Information</h3>
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12 bg-gray-200 rounded-full flex items-center justify-center">
                                            <svg class="h-6 w-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $product->seller->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $product->seller->email }}</div>
                                            <div class="text-sm text-gray-500">{{ $product->seller->business_name ?? 'No business name' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openRejectModal(productId) {
        // Create modal if it doesn't exist
        if (!document.getElementById('rejectModal')) {
            const modalHtml = `
                <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
                    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                        <div class="mt-3">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900">Reject Product</h3>
                                <button onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-500">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <form id="rejectForm" method="POST" class="mt-4">
                                @csrf
                                @method('PATCH')
                                <div class="mb-4">
                                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-1">Reason for Rejection</label>
                                    <textarea id="rejection_reason" name="rejection_reason" rows="4" 
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500"
                                              placeholder="Please provide a reason for rejecting this product..." required></textarea>
                                </div>
                                <div class="flex justify-end space-x-3">
                                    <button type="button" onclick="closeRejectModal()" 
                                            class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                        Cancel
                                    </button>
                                    <button type="submit" 
                                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                        Reject Product
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', modalHtml);
        }
        
        // Set form action and show modal
        const form = document.getElementById('rejectForm');
        form.action = `/admin/products/${productId}/reject`;
        document.getElementById('rejectModal').classList.remove('hidden');
        document.getElementById('rejection_reason').value = '';
    }
    
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }
    
    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('rejectModal');
        if (modal && !modal.classList.contains('hidden') && event.target === modal) {
            closeRejectModal();
        }
    });
</script>
@endsection