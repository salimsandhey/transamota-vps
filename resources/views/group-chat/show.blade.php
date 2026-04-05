@extends(auth()->user()->role === 'seller' ? 'layouts.app' : 'layouts.app')

@section('content')
<div class="flex flex-col " style="height: calc(100dvh - 164.67px)">
    <div class="flex flex-1 overflow-hidden">
        @if(auth()->user()->role === 'seller')
            @include('layouts.nav.seller-sidebar')
        @else
            @include('layouts.nav.buyer-sidebar')
        @endif

        <!-- Main Content -->
        <div class="flex-1 overflow-hidden">
            <div class="h-full">
                <div class="bg-white shadow-sm border border-gray-200 overflow-hidden flex flex-col h-full">
                    <!-- Chat Header -->
                    <div class="border-b border-gray-200 px-4 md:px-6 py-4 flex-shrink-0 bg-white">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <a href="{{ route('group-chat.index') }}" class="flex items-center gap-2 px-3 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200 mr-3 md:mr-4">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                    <span class="hidden md:inline">Back</span>
                                </a>
                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center">
                                    <span class="text-white font-medium">
                                        {{ substr($groupChat->name, 0, 1) }}
                                    </span>
                                </div>
                                <div class="ml-3 md:ml-4">
                                    <h3 class="text-base font-semibold text-gray-900">{{ $groupChat->name }}</h3>
                                    <p class="text-sm text-green-500 flex items-center">
                                        <span class="flex h-2 w-2 mr-1">
                                            <span class="animate-ping absolute h-2 w-2 rounded-full bg-green-400 opacity-75"></span>
                                        <span class="relative h-2 w-2 rounded-full bg-green-500"></span>
                                        </span>
                                        {{ $groupChat->users->count() }} members
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
                            @include('group-chat.message', ['message' => $message])
                        @endforeach
                    </div>
                    
                    <!-- Message Input -->
                    <div class="border-t border-gray-200 p-4 bg-white flex-shrink-0">
                        <form id="message-form" class="flex flex-col">
                            @csrf
                            <input type="hidden" id="group-chat-id" value="{{ $groupChat->id }}">
                            <div class="flex gap-2">
                                <div class="flex-1 flex gap-2">
                                    <input type="text" name="message" id="message-input" class="flex-1 border border-gray-300 rounded-full px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Type your message...">
                                    <button type="submit" class="flex items-center justify-center w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full hover:from-blue-600 hover:to-indigo-700 transition-all shadow-md">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
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
    
    const groupChatId = document.getElementById('group-chat-id').value;
    
    // Get user's timezone
    const userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    console.log('User timezone:', userTimezone);
    
    // Scroll to bottom of messages
    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    // Initial scroll to bottom
    if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    // Handle form submission
    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message-input');
    
    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(messageForm);
        
        fetch(`/group-chat/${groupChatId}/message`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'error') {
                alert('Error: ' + data.message);
            } else {
                // Don't add the message to DOM here since it will be added via Echo event listener
                // Clear inputs
                messageInput.value = '';
                messageInput.focus();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while sending the message: ' + error.message);
        });
    });
    
    // Listen for new messages using Laravel Echo
    console.log('Setting up Echo listener for group chat: {{ $groupChat->id }}');
    const echoChannel = window.Echo.private('group-chat.{{ $groupChat->id }}');
    console.log('Connected to group chat channel:', echoChannel);
    
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
        .listen('.group.message.sent', (e) => {
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
                                <p class="break-words whitespace-pre-wrap">${message.message_text}</p>
                                <div class="text-xs mt-2 text-gray-500 flex justify-end">
                                    ${formatTimestamp(message.created_at)}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                // Sender message (right aligned)
                messageDiv.innerHTML = `
                    <div class="flex justify-end">
                        <div class="inline-block max-w-xs md:max-w-md lg:max-w-lg bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-2xl rounded-tr-none shadow-sm p-4">
                            <p class="break-words whitespace-pre-wrap">${message.message_text}</p>
                            <div class="text-xs mt-2 text-blue-100 flex justify-end">
                                ${formatTimestamp(message.created_at)}
                            </div>
                        </div>
                    </div>
                `;
            }
            
            if (chatMessages) {
                // For group chats, check if message already exists to prevent duplication
                const existingMessage = chatMessages.querySelector(`[data-message-id="${message.id}"]`);
                if (!existingMessage) {
                    // For group chats, always append new messages at the end
                    chatMessages.appendChild(messageDiv);
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            }
        })
        .error((error) => {
            console.error('Echo channel error:', error);
        });
    
});
</script>
@endsection