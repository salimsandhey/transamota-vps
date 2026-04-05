@extends(auth()->user()->role === 'seller' ? 'layouts.app' : 'layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex flex-1 bg-gray-50">
        @if(auth()->user()->role === 'seller')
            @include('layouts.nav.seller-sidebar')
        @else
            @include('layouts.nav.buyer-sidebar')
        @endif

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <div class="p-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h2 class="text-lg font-semibold text-gray-900">
                            @if(auth()->user()->role === 'seller')
                                Customer Inquiries
                            @else
                                My Inquiries
                            @endif
                        </h2>
                    </div>
                    
                    @if($inquiries->isEmpty())
                        <div class="text-center py-12">
                            <div class="mx-auto w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center mb-6">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">
                                @if(auth()->user()->role === 'seller')
                                    No customer inquiries yet
                                @else
                                    No inquiries yet
                                @endif
                            </h3>
                            <p class="text-gray-500 max-w-md mx-auto">
                                @if(auth()->user()->role === 'seller')
                                    When customers inquire about your products, they will appear here.
                                @else
                                    When you add products to your inquiries, they will appear here.
                                @endif
                            </p>
                        </div>
                    @else
                        <div class="divide-y divide-gray-100">
                            @foreach($inquiries as $inquiry)
                                <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center">
                                        @if($inquiry->product->images->first())
                                            <div class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden">
                                                <img src="/storage/{{ $inquiry->product->images->first()->image_path }}" alt="{{ $inquiry->product->name }}" class="w-full h-full object-cover">
                                            </div>
                                        @else
                                            <div class="flex-shrink-0 w-16 h-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        
                                        <div class="ml-4 flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <h4 class="font-medium text-gray-900 truncate">{{ $inquiry->product->name }}</h4>
                                                <span class="text-xs text-gray-500 whitespace-nowrap ml-2">
                                                    {{ $inquiry->added_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            
                                            <div class="mt-1 flex items-center text-sm text-gray-500">
                                                @if(auth()->user()->role === 'seller')
                                                    <span>From: {{ $inquiry->conversation->buyer->name }}</span>
                                                @else
                                                    <span>Seller: {{ $inquiry->conversation->seller->name }}</span>
                                                @endif
                                            </div>
                                            
                                            <div class="mt-2 flex items-center">
                                                <span class="text-lg font-semibold text-gray-900">
                                                    @if($inquiry->product->price)
                                                        ₹{{ number_format($inquiry->product->price, 2) }}
                                                    @else
                                                        Price on request
                                                    @endif
                                                </span>
                                                <span class="mx-2 text-gray-300">•</span>
                                                <span class="text-sm text-gray-500">MOQ: {{ $inquiry->product->moq }} {{ $inquiry->product->unit }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="ml-4 flex flex-col items-end space-y-2">
                                            <a href="{{ route('chat.show', $inquiry->conversation->slug) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">
                                                @if(auth()->user()->role === 'seller')
                                                    Chat with Customer
                                                @else
                                                    Continue Chat
                                                @endif
                                            </a>
                                            <button 
                                                data-inquiry-id="{{ $inquiry->id }}"
                                                class="remove-from-inquiry px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle remove from inquiry button clicks
    const removeButtons = document.querySelectorAll('.remove-from-inquiry');
    
    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const inquiryId = this.getAttribute('data-inquiry-id');
            
            if (confirm('Are you sure you want to remove this product from your inquiries?')) {
                fetch(`/inquiries/remove`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        inquiry_id: inquiryId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the inquiry row from the DOM
                        this.closest('.px-6.py-4').remove();
                        
                        // Show a success message
                        alert('Product removed from inquiries successfully.');
                        
                        // If all inquiries are removed, show the empty state
                        const inquiryRows = document.querySelectorAll('.px-6.py-4');
                        if (inquiryRows.length === 0) {
                            location.reload();
                        }
                    } else {
                        alert('Error removing product from inquiries: ' + (data.error || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while removing the product from inquiries.');
                });
            }
        });
    });
});
</script>
@endsection