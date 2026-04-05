@extends('layouts.app')

@section('content')
<div class="flex flex-col" style="height: calc(100dvh - 164.67px)">
    <div class="flex flex-1 overflow-hidden">
        @if(auth()->user()->role === 'seller')
            @include('layouts.nav.seller-sidebar')
        @else
            @include('layouts.nav.buyer-sidebar')
        @endif

        <div class="flex-1 overflow-hidden">
            <div class="h-full">
                <div class="bg-white shadow-sm border border-gray-200 overflow-hidden flex flex-col h-full"> 
                    <div class="border-b border-gray-200 px-6 py-4 flex-shrink-0">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <a href="{{ route('chat.index') }}" class="flex items-center gap-2 px-3 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200 mr-4">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                    <span class="hidden md:inline">Back</span>
                                </a>
                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center">
                                    <span class="text-white font-medium">
                                        @if(auth()->user()->role === 'seller')
                                            {{ substr($conversation->buyer->name, 0, 1) }}
                                        @else
                                            {{ substr($conversation->seller->name, 0, 1) }}
                                        @endif
                                    </span>
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-medium text-gray-900">
                                        @if(auth()->user()->role === 'seller')
                                            {{ $conversation->buyer->name }}
                                        @else
                                            {{ $conversation->seller->name }}
                                        @endif
                                    </h3>
                                    <p class="text-sm text-green-500 flex items-center">
                                        <span class="flex h-2 w-2 mr-1">
                                            <span class="animate-ping absolute h-2 w-2 rounded-full bg-green-400 opacity-75"></span>
                                            <span class="relative h-2 w-2 rounded-full bg-green-500"></span>
                                        </span>
                                        Online
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button class="p-2 rounded-full hover:bg-gray-100 text-gray-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Chat Messages -->
                    <div id="chat-messages" class="flex-1 overflow-y-auto bg-gradient-to-b from-gray-50 to-white p-4 md:p-6">
                        @foreach($messages as $message)
                            <div class="message mb-4 {{ $message->sender_id === auth()->id() ? 'text-right' : 'text-left' }}" data-message-id="{{ $message->id }}">
                                @if($message->sender_id !== auth()->id())
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center">
                                            <span class="text-white text-xs font-medium">
                                                @if(auth()->user()->role === 'seller')
                                                    {{ substr($conversation->buyer->name, 0, 1) }}
                                                @else
                                                    {{ substr($conversation->seller->name, 0, 1) }}
                                                @endif
                                            </span>
                                        </div>
                                        <div class="ml-2 md:ml-3">
                                            <div class="inline-block max-w-xs md:max-w-md lg:max-w-lg bg-white text-gray-800 rounded-2xl rounded-tl-none shadow-sm p-4">
                                                @if($message->message_type === 'image')
                                                    <div>
                                                        <img src="{{ asset('storage/' . $message->file_path) }}" alt="Image" class="rounded-lg max-w-full h-auto" style="max-height: 200px;">
                                                    </div>
                                                @else
                                                    @if(preg_match('/\[Product: (.+?)\]/', $message->message_text, $matches))
                                                        <div class="mb-2">
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                                </svg>
                                                                Product: {{ $matches[1] }}
                                                            </span>
                                                        </div>
                                                        <pre class="whitespace-pre-wrap">{{ preg_replace('/\[Product: .+?\]\n?/', '', $message->message_text) }}</pre>
                                                    @else
                                                        <p class="break-words whitespace-pre-wrap">{{ $message->message_text }}</p>
                                                    @endif
                                                @endif
                                                <div class="text-xs mt-2 text-gray-500 flex justify-end">
                                                    {{ $message->created_at->setTimezone(auth()->user()->timezone ?? 'UTC')->format('M d, Y g:i A') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex justify-end">
                                        <div class="inline-block max-w-xs md:max-w-md lg:max-w-lg bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-2xl rounded-tr-none shadow-sm p-4">
                                            @if($message->message_type === 'image')
                                                <div>
                                                    <img src="{{ asset('storage/' . $message->file_path) }}" alt="Image" class="rounded-lg max-w-full h-auto" style="max-height: 200px;">
                                                </div>
                                            @else
                                                @if(preg_match('/\[Product: (.+?)\]/', $message->message_text, $matches))
                                                    <div class="mb-2">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-200 text-blue-900">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                            </svg>
                                                            Product: {{ $matches[1] }}
                                                        </span>
                                                    </div>
                                                    <pre class="whitespace-pre-wrap text-blue-100">{{ preg_replace('/\[Product: .+?\]\n?/', '', $message->message_text) }}</pre>
                                                @else
                                                    <p class="break-words whitespace-pre-wrap">{{ $message->message_text }}</p>
                                                @endif
                                            @endif
                                            <div class="text-xs mt-2 text-blue-100 flex justify-end">
                                                {{ $message->created_at->setTimezone(auth()->user()->timezone ?? 'UTC')->format('M d, Y g:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Message Input -->
                    <div class="border-t border-gray-200 p-4 bg-white flex-shrink-0">
                        <form id="message-form" class="flex flex-col">
                            @csrf
                            <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                            <!-- Product selector - hidden by default, shown when needed -->
                            <div id="product-selector-container" class="mb-3 hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Select Product (Optional)</label>
                                <select name="product_id" id="product-selector" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select a product to reference</option>
                                    <!-- Products will be populated dynamically -->
                                </select>
                            </div>
                            <div class="flex gap-2">
                                <div class="flex-1 flex gap-2">
                                    <input type="text" name="message" id="message-input" class="flex-1 border border-gray-300 rounded-full px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Type your message...">
                                    <input type="file" name="image" id="image-input" class="hidden" accept="image/*">
                                    <label for="image-input" class="flex items-center justify-center w-12 h-12 bg-gray-100 text-gray-700 rounded-full cursor-pointer hover:bg-gray-200 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </label>
                                    <!-- Product reference button -->
                                    <button type="button" id="product-reference-btn" class="flex items-center justify-center w-12 h-12 bg-gray-100 text-gray-700 rounded-full cursor-pointer hover:bg-gray-200 transition-colors" title="Reference a product">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </button>
                                </div>
                                <button type="submit" class="flex items-center justify-center w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full hover:from-blue-600 hover:to-indigo-700 transition-all shadow-md">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                </button>
                            </div>
                            <!-- Image preview container -->
                            <div id="image-preview-container" class="mt-3 hidden">
                                <div class="flex items-center justify-between bg-gray-100 rounded-lg p-2">
                                    <img id="image-preview" src="" alt="Preview" class="h-16 w-16 object-cover rounded">
                                    <button id="remove-preview" class="ml-2 text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get chat messages container
        const chatMessages = document.getElementById('chat-messages');
        
        // Scroll to bottom of chat
        if (chatMessages) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
        
        // Check if Echo is available
        if (typeof window.Echo === 'undefined') {
            console.error('Echo is not available');
            return;
        }
        
        console.log('Echo is available, connecting to channel for user: {{ auth()->id() }}');
        
        // Get user's timezone
        const userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        console.log('User timezone:', userTimezone);
        
        // Listen for new messages using Laravel Echo
        console.log('Setting up Echo listener for conversation: {{ $conversation->id }}');
        const echoChannel = window.Echo.private('conversation.{{ $conversation->id }}');
        console.log('Connected to conversation channel:', echoChannel);
        
        // Add connection state logging
        if (window.Echo.connector.pusher) {
            window.Echo.connector.pusher.connection.bind('connected', function() {
                console.log('Pusher connected successfully');
            });
            
            window.Echo.connector.pusher.connection.bind('disconnected', function() {
                console.log('Pusher disconnected');
            });
            
            window.Echo.connector.pusher.connection.bind('error', function(err) {
                console.error('Pusher connection error:', err);
            });
        }
        
        // Format timestamp to match PHP format 'M d, Y g:i A' in user's timezone
        function formatTimestamp(timestamp) {
            // Handle null/undefined/empty timestamp
            if (!timestamp) {
                return 'Just now';
            }
            
            // If timestamp is already a Date object, use it directly
            let date;
            if (timestamp instanceof Date) {
                date = timestamp;
            } else if (typeof timestamp === 'string') {
                // Try to parse the string timestamp
                // Handle various formats that might come from Laravel
                if (timestamp.includes(' ')) {
                    // If it looks like a MySQL datetime (YYYY-MM-DD HH:MM:SS)
                    date = new Date(timestamp.replace(' ', 'T'));
                } else {
                    // Try standard parsing
                    date = new Date(timestamp);
                }
            } else if (typeof timestamp === 'number') {
                // If it's a Unix timestamp in seconds
                date = new Date(timestamp * 1000);
            } else {
                // Try to convert to Date anyway
                date = new Date(timestamp);
            }
            
            // Check if date is valid
            if (isNaN(date.getTime())) {
                return 'Just now';
            }
            
            // Format to match PHP format 'M d, Y g:i A' (e.g., "Dec 02, 2025 2:30 PM") in user's timezone
            const options = {
                year: 'numeric',
                month: 'short',
                day: '2-digit',
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            };
            
            // Use user's timezone for formatting
            return date.toLocaleString('en-US', { ...options, timeZone: userTimezone });
        }
        
        // Add error handling
        echoChannel
            .listen('.message.sent', (e) => {
                console.log('Received message event:', e);
                if (!e || !e.message) {
                    console.error('Invalid message event received:', e);
                    return;
                }
                const message = e.message;
                
                // Add message to chat
                const messageDiv = document.createElement('div');
                messageDiv.className = 'message mb-4 ' + (message.sender_id === {{ auth()->id() }} ? 'text-right' : 'text-left');
                // Add data attribute to track message ID for duplication prevention
                messageDiv.setAttribute('data-message-id', message.id);
                
                if (message.sender_id !== {{ auth()->id() }}) {
                    // Receiver message (left aligned)
                    messageDiv.innerHTML = `
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center">
                                <span class="text-white text-xs font-medium">
                                    ${message.sender.name.charAt(0)}
                                </span>
                            </div>
                            <div class="ml-2 md:ml-3">
                                <div class="text-xs font-medium text-gray-900 mb-1">${message.sender.name}</div>
                                <div class="inline-block max-w-xs md:max-w-md lg:max-w-lg bg-white text-gray-800 rounded-2xl rounded-tl-none shadow-sm p-4">
                                    ${message.message_type === 'image' ? 
                                        `<div><img src="/storage/${message.file_path}" alt="Image" class="rounded-lg max-w-full h-auto" style="max-height: 200px;"></div>` : 
                                        (message.message_text.includes('[Product:') ? 
                                            `<div class="mb-2"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"><svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>Product: ${message.message_text.match(/\[Product: (.+?)\]/)[1]}</span></div><pre class="whitespace-pre-wrap">${message.message_text.replace(/\[Product: .+?\]\n?/, '')}</pre>` : 
                                            `<p class="break-words whitespace-pre-wrap">${message.message_text}</p>`)}
                                <div class="text-xs mt-2 text-gray-500 flex justify-end">
                                    ${formatTimestamp(message.created_at)}
                                </div>
                            </div>
                        </div>
                    `;
                } else {
                    // Sender message (right aligned)
                    messageDiv.innerHTML = `
                        <div class="flex justify-end">
                            <div class="inline-block max-w-xs md:max-w-md lg:max-w-lg bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-2xl rounded-tr-none shadow-sm p-4">
                                ${message.message_type === 'image' ? 
                                    `<div><img src="/storage/${message.file_path}" alt="Image" class="rounded-lg max-w-full h-auto" style="max-height: 200px;"></div>` : 
                                    (message.message_text.includes('[Product:') ? 
                                        `<div class="mb-2"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-200 text-blue-900"><svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>Product: ${message.message_text.match(/\[Product: (.+?)\]/)[1]}</span></div><pre class="whitespace-pre-wrap text-blue-100">${message.message_text.replace(/\[Product: .+?\]\n?/, '')}</pre>` : 
                                        `<p class="break-words whitespace-pre-wrap">${message.message_text}</p>`)}
                            <div class="text-xs mt-2 text-blue-100 flex justify-end">
                                ${formatTimestamp(message.created_at)}
                            </div>
                        </div>
                    `;
                }
                
                if (chatMessages) {
                    // For single chats, check if message already exists to prevent duplication
                    const existingMessage = chatMessages.querySelector(`[data-message-id="${message.id}"]`);
                    if (!existingMessage) {
                        // For single chats, always append new messages at the end
                        chatMessages.appendChild(messageDiv);
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    }
                }
            })
            .error((error) => {
                console.error('Echo channel error:', error);
            });
        
        // Handle form submission
        const messageForm = document.getElementById('message-form');
        const messageInput = document.getElementById('message-input');
        const imageInput = document.getElementById('image-input');
        const productSelectorContainer = document.getElementById('product-selector-container');
        const productSelector = document.getElementById('product-selector');
        const productReferenceBtn = document.getElementById('product-reference-btn');
        
        // Handle product reference button click
        if (productReferenceBtn) {
            productReferenceBtn.addEventListener('click', function() {
                // Toggle product selector visibility
                productSelectorContainer.classList.toggle('hidden');
                
                // If showing for the first time, populate with seller's products
                if (!productSelectorContainer.classList.contains('hidden') && productSelector.children.length <= 1) {
                    fetchSellerProducts({{ $conversation->seller_id }});
                }
            });
        }
        
        // Function to fetch seller's products
        function fetchSellerProducts(sellerId) {
            fetch(`/chat/seller/${sellerId}/products`)
                .then(response => response.json())
                .then(products => {
                    // Clear existing options except the first one
                    while (productSelector.children.length > 1) {
                        productSelector.removeChild(productSelector.lastChild);
                    }
                    
                    // Add products to the selector
                    products.forEach(product => {
                        const option = document.createElement('option');
                        option.value = product.id;
                        option.textContent = product.name;
                        productSelector.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching seller products:', error);
                });
        }
        
        // Handle image preview
        imageInput.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const previewContainer = document.getElementById('image-preview-container');
                    const previewImage = document.getElementById('image-preview');
                    
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }
                
                reader.readAsDataURL(e.target.files[0]);
            }
        });
        
        // Handle remove preview
        document.getElementById('remove-preview').addEventListener('click', function() {
            imageInput.value = '';
            document.getElementById('image-preview-container').classList.add('hidden');
        });
        
        messageForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(messageForm);
            
            fetch("{{ route('chat.send-message') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    // Don't add the message to DOM here since it will be added via Echo event listener
                    // Clear inputs
                    messageInput.value = '';
                    imageInput.value = '';
                    
                    // Hide product selector
                    productSelectorContainer.classList.add('hidden');
                    productSelector.value = '';
                    
                    // Remove any existing image preview
                    const existingPreview = document.getElementById('image-preview-container');
                    if (existingPreview) {
                        existingPreview.classList.add('hidden');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while sending the message.');
            });
        });
    });
</script>
@endsection