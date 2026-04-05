<div class="message mb-4 {{ $message->sender_id === auth()->id() ? 'text-right' : 'text-left' }}" data-message-id="{{ $message->id }}">
    @if($message->sender_id !== auth()->id())
        <div class="flex items-start">
            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center">
                <span class="text-white text-xs font-medium">
                    {{ substr($message->sender->name, 0, 1) }}
                </span>
            </div>
            <div class="ml-2 md:ml-3">
                <div class="text-xs font-medium text-gray-900 mb-1">{{ $message->sender->name }}</div>
                <div class="inline-block max-w-xs md:max-w-md lg:max-w-lg bg-white text-gray-800 rounded-2xl rounded-tl-none shadow-sm p-4">
                    <p class="break-words whitespace-pre-wrap">{{ $message->message_text }}</p>
                    <div class="text-xs mt-2 text-gray-500 flex justify-end">
                        {{ $message->created_at->setTimezone(auth()->user()->timezone ?? 'UTC')->format('M d, Y g:i A') }}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="flex justify-end">
            <div class="inline-block max-w-xs md:max-w-md lg:max-w-lg bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-2xl rounded-tr-none shadow-sm p-4">
                <p class="break-words whitespace-pre-wrap">{{ $message->message_text }}</p>
                <div class="text-xs mt-2 text-blue-100 flex justify-end">
                    {{ $message->created_at->setTimezone(auth()->user()->timezone ?? 'UTC')->format('M d, Y g:i A') }}
                </div>
            </div>
        </div>
    @endif
</div>