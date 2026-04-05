@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        @include('layouts.nav.admin-sidebar')

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- @include('layouts.nav.admin-header') -->
            
            @include('layouts.nav.content-header', [
                'title' => 'Product Verification',
                'subtitle' => 'Review and verify products submitted by sellers',
                'headerActions' => ''
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

            <!-- Product Verification -->
            <div class="p-8">
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Product Verification</h3>
                            <p class="text-sm text-gray-600">Review and verify products submitted by sellers. Only verified products will be visible to buyers.</p>
                        </div>
                    </div>
                    
                    <!-- Product Filters -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <form method="GET" action="{{ route('admin.verifications.products.index') }}">
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Product name or description" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                    <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Seller</label>
                                    <select name="seller" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">All Sellers</option>
                                        @foreach($sellers as $sel)
                                            <option value="{{ $sel->id }}" {{ request('seller') == $sel->id ? 'selected' : '' }}>
                                                {{ $sel->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Verification Status</label>
                                    <select name="verification_status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">All Statuses</option>
                                        @foreach($verificationStatuses as $status)
                                            <option value="{{ $status }}" {{ request('verification_status') == $status ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="flex items-end gap-2">
                                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        Filter
                                    </button>
                                    <a href="{{ route('admin.verifications.products.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                        Clear
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    @if($productsPendingVerification->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left text-xs text-gray-500 border-b border-gray-200">
                                        <th class="pb-3 font-medium">Product</th>
                                        <th class="pb-3 font-medium">Seller</th>
                                        <th class="pb-3 font-medium">Category</th>
                                        <th class="pb-3 font-medium">Price</th>
                                        <th class="pb-3 font-medium">Submitted</th>
                                        <th class="pb-3 font-medium text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($productsPendingVerification as $product)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-4">
                                            <div class="flex items-center gap-3">
                                                @if($product->primaryImage)
                                                    <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" alt="{{ $product->name }}" class="w-10 h-10 rounded-lg object-cover">
                                                @else
                                                    <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="font-medium text-gray-800 text-sm">{{ $product->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ Str::limit($product->description, 30) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4">
                                            <div class="text-sm text-gray-600">{{ $product->seller->name }}</div>
                                        </td>
                                        <td class="py-4">
                                            <div class="text-sm text-gray-600">{{ $product->category->name ?? 'N/A' }}</div>
                                        </td>
                                        <td class="py-4">
                                            <div class="text-sm font-medium text-gray-800">₹{{ number_format($product->price, 2) }}</div>
                                        </td>
                                        <td class="py-4 text-sm text-gray-600">
                                            {{ $product->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.verifications.products.show', $product) }}" class="text-blue-600 hover:text-blue-800 cursor-pointer" title="View Product">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </a>
                                                
                                                @if($product->verification_status === 'pending')
                                                <form method="POST" action="{{ route('admin.verifications.products.approve', $product) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                            class="text-green-600 hover:text-green-800 cursor-pointer"
                                                            title="Approve Product">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                                
                                                <form method="POST" action="{{ route('admin.verifications.products.reject', $product) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="button" 
                                                            class="text-red-600 hover:text-red-800 cursor-pointer"
                                                            title="Reject Product"
                                                            onclick="openRejectModal({{ $product->id }})">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                                @else
                                                    <span class="text-sm text-gray-500">
                                                        {{ ucfirst($product->verification_status) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        @if(method_exists($productsPendingVerification, 'hasPages') && $productsPendingVerification->hasPages())
                        <div class="flex items-center justify-between mt-6">
                            <div class="text-sm text-gray-600">
                                Showing {{ $productsPendingVerification->firstItem() }} to {{ $productsPendingVerification->lastItem() }} of {{ $productsPendingVerification->total() }} results
                            </div>
                            <div class="mt-4">
                                {{ $productsPendingVerification->appends(request()->query())->links() }}
                            </div>
                        </div>
                        @endif
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No products to verify</h3>
                            <p class="mt-1 text-sm text-gray-500">There are no products matching your search criteria.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Function to open rejection modal
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
                            <input type="hidden" name="product_id" id="reject_product_id">
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
        
        // Add event listener to the form
        document.getElementById('rejectForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const productId = document.getElementById('reject_product_id').value;
            const rejectionReason = document.getElementById('rejection_reason').value;
            
            // Create a hidden form to submit the data
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/verifications/products/${productId}/reject`;
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);
            
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PATCH';
            form.appendChild(methodInput);
            
            const reasonInput = document.createElement('input');
            reasonInput.type = 'hidden';
            reasonInput.name = 'rejection_reason';
            reasonInput.value = rejectionReason;
            form.appendChild(reasonInput);
            
            document.body.appendChild(form);
            form.submit();
        });
    }
    
    // Set product ID and show modal
    document.getElementById('reject_product_id').value = productId;
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