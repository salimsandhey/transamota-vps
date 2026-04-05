@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        @include('layouts.nav.admin-sidebar')

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            @include('layouts.nav.admin-header')
            
            @include('layouts.nav.content-header', [
                'title' => 'Product Verification',
                'subtitle' => 'Review product details and verify for public listing',
                'headerActions' => '<a href="' . route('admin.verifications.products.index') . '" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to Verifications
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

            <div class="p-8">
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Product Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Product Information</h3>
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    @if($product->primaryImage)
                                        <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" alt="{{ $product->name }}" class="flex-shrink-0 w-12 h-12 rounded-lg object-cover">
                                    @else
                                        <div class="flex-shrink-0 w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-lg font-medium text-gray-900">{{ $product->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $product->category->name ?? 'Uncategorized' }}</div>
                                    </div>
                                </div>
                                
                                @if($product->images->count() > 0)
                                <div class="border-t border-gray-200 pt-4">
                                    <dt class="text-sm font-medium text-gray-500 mb-2">Product Images</dt>
                                    <div class="grid grid-cols-3 gap-2">
                                        @foreach($product->images as $image)
                                        <div class="relative">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product image" class="rounded-lg object-cover w-full h-20">
                                            @if($image->is_primary)
                                            <span class="absolute top-1 left-1 bg-blue-500 text-white text-xs px-1 py-0.5 rounded">Primary</span>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                
                                <div class="border-t border-gray-200 pt-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Price</dt>
                                            <dd class="mt-1 text-sm text-gray-900">₹{{ number_format($product->price, 2) }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                                            <dd class="mt-1 text-sm text-gray-900 capitalize">{{ $product->status }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Created</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $product->created_at->format('M d, Y') }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Verification Status</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                @if($product->verification_status === 'approved')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Approved
                                                    </span>
                                                @elseif($product->verification_status === 'rejected')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Rejected
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Pending
                                                    </span>
                                                @endif
                                            </dd>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="border-t border-gray-200 pt-4">
                                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $product->description ?? 'No description provided' }}</dd>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Seller & Verification -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Seller Information</h3>
                            <div class="border border-gray-200 rounded-lg p-4 mb-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $product->seller->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $product->seller->email }}</div>
                                    </div>
                                </div>
                                
                                <div class="mt-3 grid grid-cols-2 gap-2">
                                    <div>
                                        <dt class="text-xs font-medium text-gray-500">Company</dt>
                                        <dd class="text-sm text-gray-900">{{ $product->seller->company_name ?? 'N/A' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-medium text-gray-500">Location</dt>
                                        <dd class="text-sm text-gray-900">{{ $product->seller->city ?? 'N/A' }}, {{ $product->seller->country ?? '' }}</dd>
                                    </div>
                                </div>
                            </div>
                            
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Verification Actions</h3>
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex space-x-3">
                                    @if($product->verification_status !== 'approved')
                                    <form method="POST" action="{{ route('admin.verifications.products.approve', $product) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            Approve Product
                                        </button>
                                    </form>
                                    @endif
                                    
                                    @if($product->verification_status !== 'rejected')
                                    <form method="POST" action="{{ route('admin.verifications.products.reject', $product) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                                onclick="return confirm('Are you sure you want to reject this product?')">
                                            <svg class="-ml-1 mr-2 h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            Reject Product
                                        </button>
                                    </form>
                                    @endif
                                </div>
                                
                                @if($product->verification_status === 'approved')
                                <div class="mt-4 text-sm text-green-600">
                                    <svg class="inline h-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    This product has been approved and is visible to buyers.
                                </div>
                                @elseif($product->verification_status === 'rejected')
                                <div class="mt-4 text-sm text-red-600">
                                    <svg class="inline h-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                    This product has been rejected and is not visible to buyers.
                                </div>
                                <!-- Display rejection reason -->
                                @if($product->rejection_reason)
                                <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                                    <h4 class="text-sm font-medium text-red-800 mb-2">Rejection Reason</h4>
                                    <p class="text-sm text-red-700">{{ $product->rejection_reason }}</p>
                                </div>
                                @endif
                                @endif
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4 mt-6">
                                <h4 class="text-md font-medium text-gray-800 mb-2">Product Actions</h4>
                                <div class="flex space-x-3">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                        Edit Product
                                    </a>
                                    
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                                onclick="return confirm('Are you sure you want to delete this product? This action cannot be undone.')">
                                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            Delete Product
                                        </button>
                                    </form>
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
// Function to open rejection modal
function openRejectModal() {
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
    form.action = "{{ route('admin.verifications.products.reject', $product) }}";
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

// Update the reject button to open the modal
document.addEventListener('DOMContentLoaded', function() {
    const rejectButton = document.querySelector('form[action="{{ route('admin.verifications.products.reject', $product) }}"] button');
    if (rejectButton) {
        rejectButton.type = 'button';
        rejectButton.onclick = function() {
            openRejectModal();
        };
        rejectButton.removeAttribute('onclick');
    }
});
</script>
@endsection