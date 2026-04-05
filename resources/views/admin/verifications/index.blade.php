@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        @include('layouts.nav.admin-sidebar')

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            @include('layouts.nav.content-header', [
                'title' => 'All Verifications',
                'subtitle' => 'Manage all verification requests',
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

            <!-- Verification Tabs -->
            <div class="p-8">
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <!-- Tabs -->
                    <div class="border-b border-gray-200 mb-6">
                        <nav class="flex space-x-8">
                            <button data-tab="all" class="tab-button py-4 px-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 {{ request()->query('tab') != 'products' ? 'active' : '' }}">
                                All Verifications
                            </button>
                            <button data-tab="products" class="tab-button py-4 px-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 {{ request()->query('tab') == 'products' ? 'active' : '' }}">
                                Product Verification
                            </button>
                        </nav>
                    </div>

                    <!-- All Verifications Tab -->
                    <div id="all-tab" class="tab-content {{ request()->query('tab') == 'products' ? 'hidden' : '' }}">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">User Verifications</h3>
                        <p class="text-sm text-gray-600 mb-4">Review and verify user accounts and documents.</p>
                        
                        @if($sellersWithDocuments->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr class="text-left text-xs text-gray-500 border-b border-gray-200">
                                            <th class="pb-3 font-medium">Seller</th>
                                            <th class="pb-3 font-medium">Document</th>
                                            <th class="pb-3 font-medium">Status</th>
                                            <th class="pb-3 font-medium">Submitted</th>
                                            <th class="pb-3 font-medium text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($sellersWithDocuments as $user)
                                        <tr class="hover:bg-gray-50">
                                            <td class="py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-gray-800 text-sm">{{ $user->name }}</div>
                                                        <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4">
                                                <div class="text-sm text-gray-600">
                                                    Business Document
                                                </div>
                                            </td>
                                            <td class="py-4">
                                                <span class="px-2 py-1 text-xs rounded-full 
                                                    @if($user->profile->verified_by_admin) bg-green-100 text-green-800 
                                                    @else bg-yellow-100 text-yellow-800 @endif">
                                                    @if($user->profile->verified_by_admin) Verified @else Pending Verification @endif
                                                </span>
                                            </td>
                                            <td class="py-4 text-sm text-gray-600">
                                                {{ $user->profile->updated_at->format('M d, Y') }}
                                            </td>
                                            <td class="py-4 text-right">
                                                <div class="flex items-center justify-end gap-2">
                                                    <a href="{{ Storage::url($user->profile->verification_doc) }}" target="_blank" 
                                                       class="text-blue-600 hover:text-blue-800" title="View Document">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                    </a>
                                                    
                                                    @if(!$user->profile->verified_by_admin)
                                                    <form method="POST" action="{{ route('admin.verifications.seller.verify', $user) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" 
                                                                class="text-green-600 hover:text-green-800"
                                                                title="Verify Document">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    @endif
                                                    
                                                    <form method="POST" action="{{ route('admin.verifications.seller.reject', $user) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" 
                                                                class="text-red-600 hover:text-red-800"
                                                                title="Reject Document"
                                                                onclick="return confirm('Are you sure you want to reject this document?')">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            @if(method_exists($sellersWithDocuments, 'hasPages') && $sellersWithDocuments->hasPages())
                            <div class="flex items-center justify-between mt-6">
                                <div class="text-sm text-gray-600">
                                    Showing {{ $sellersWithDocuments->firstItem() }} to {{ $sellersWithDocuments->lastItem() }} of {{ $sellersWithDocuments->total() }} results
                                </div>
                                <div class="mt-4">
                                    {{ $sellersWithDocuments->links() }}
                                </div>
                            </div>
                            @endif
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No documents to verify</h3>
                                <p class="mt-1 text-sm text-gray-500">There are no seller documents pending verification. All sellers have either verified documents or haven't uploaded any yet.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Buyer Approvals Tab -->
                    <div id="buyers-tab" class="tab-content hidden">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Buyer Approvals</h3>
                        <p class="text-sm text-gray-600 mb-4">Approve or reject buyer accounts. Approved buyers can message sellers and request quotes.</p>
                        
                        @if($buyers->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr class="text-left text-xs text-gray-500 border-b border-gray-200">
                                            <th class="pb-3 font-medium">Buyer</th>
                                            <th class="pb-3 font-medium">Email Status</th>
                                            <th class="pb-3 font-medium">Status</th>
                                            <th class="pb-3 font-medium">Registered</th>
                                            <th class="pb-3 font-medium text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($buyers as $user)
                                        <tr class="hover:bg-gray-50">
                                            <td class="py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-gray-800 text-sm">{{ $user->name }}</div>
                                                        <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4">
                                                <span class="px-2 py-1 text-xs rounded-full 
                                                    @if($user->email_verified_at) bg-green-100 text-green-800 
                                                    @else bg-yellow-100 text-yellow-800 @endif">
                                                    @if($user->email_verified_at) Verified @else Unverified @endif
                                                </span>
                                            </td>
                                            <td class="py-4">
                                                <span class="px-2 py-1 text-xs rounded-full 
                                                    @if($user->is_verified) bg-green-100 text-green-800 
                                                    @else bg-yellow-100 text-yellow-800 @endif">
                                                    @if($user->is_verified) Approved @else Pending Approval @endif
                                                </span>
                                            </td>
                                            <td class="py-4 text-sm text-gray-600">
                                                {{ $user->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="py-4 text-right">
                                                <div class="flex items-center justify-end gap-2">
                                                    @if(!$user->is_verified)
                                                    <form method="POST" action="{{ route('admin.verifications.buyer.approve', $user) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" 
                                                                class="text-green-600 hover:text-green-800"
                                                                title="Approve Buyer">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    @endif
                                                    
                                                    <form method="POST" action="{{ route('admin.verifications.buyer.reject', $user) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" 
                                                                class="text-red-600 hover:text-red-800"
                                                                title="Reject Buyer"
                                                                onclick="return confirm('Are you sure you want to reject this buyer?')">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            @if(method_exists($buyers, 'hasPages') && $buyers->hasPages())
                            <div class="flex items-center justify-between mt-6">
                                <div class="text-sm text-gray-600">
                                    Showing {{ $buyers->firstItem() }} to {{ $buyers->lastItem() }} of {{ $buyers->total() }} results
                                </div>
                                <div class="mt-4">
                                    {{ $buyers->links() }}
                                </div>
                            </div>
                            @endif
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No buyers to approve</h3>
                                <p class="mt-1 text-sm text-gray-500">There are no buyers pending approval. All buyers have either been approved or rejected.</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Product Verification Tab -->
                    <div id="products-tab" class="tab-content {{ request()->query('tab') != 'products' ? 'hidden' : '' }}">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Product Verification</h3>
                        <p class="text-sm text-gray-600 mb-4">Review and verify products submitted by sellers. Only verified products will be visible to buyers.</p>
                        
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
                                                    <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                                        </svg>
                                                    </div>
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
                                                <div class="text-sm font-medium text-gray-800">${{ number_format($product->price, 2) }}</div>
                                            </td>
                                            <td class="py-4 text-sm text-gray-600">
                                                {{ $product->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="py-4 text-right">
                                                <div class="flex items-center justify-end gap-2">
                                                    <a href="#" class="text-blue-600 hover:text-blue-800" title="View Product">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                    </a>
                                                    
                                                    <form method="POST" action="{{ route('admin.verifications.product.approve', $product) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" 
                                                                class="text-green-600 hover:text-green-800"
                                                                title="Approve Product">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    
                                                    <form method="POST" action="{{ route('admin.verifications.product.reject', $product) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" 
                                                                class="text-red-600 hover:text-red-800"
                                                                title="Reject Product"
                                                                onclick="return confirm('Are you sure you want to reject this product?')">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
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
                                    {{ $productsPendingVerification->links() }}
                                </div>
                            </div>
                            @endif
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No products to verify</h3>
                                <p class="mt-1 text-sm text-gray-500">There are no products pending verification.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons and contents
            tabButtons.forEach(btn => btn.classList.remove('active', 'text-blue-600', 'border-blue-500'));
            tabButtons.forEach(btn => btn.classList.add('text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'border-transparent'));
            tabContents.forEach(content => content.classList.add('hidden'));
            
            // Add active class to clicked button
            this.classList.remove('text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'border-transparent');
            this.classList.add('active', 'text-blue-600', 'border-blue-500');
            
            // Show corresponding content
            const tabName = this.getAttribute('data-tab');
            document.getElementById(`${tabName}-tab`).classList.remove('hidden');
        });
    });
});
</script>
@endsection