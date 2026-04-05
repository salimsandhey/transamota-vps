<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct(Message $message)
    {
        $this->message = $message->load(['sender', 'conversation']);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        error_log('Broadcasting message to conversation channel: conversation.' . $this->message->conversation_id);
        \Log::info('Broadcasting message to conversation channel', [
            'conversation_id' => $this->message->conversation_id,
            'buyer_id' => $this->message->conversation->buyer_id,
            'seller_id' => $this->message->conversation->seller_id,
            'message_id' => $this->message->id,
            'channel_name' => 'conversation.' . $this->message->conversation_id,
            'event_class' => static::class
        ]);
        
        // Broadcast to conversation channel (Echo will automatically prepend 'private-')
        return [
            new PrivateChannel('conversation.' . $this->message->conversation_id),
        ];
    }
    
    public function broadcastWith()
    {
        // Add formatted timestamp to the broadcast data
        $data = [
            'message' => [
                'id' => $this->message->id,
                'conversation_id' => $this->message->conversation_id,
                'sender_id' => $this->message->sender_id,
                'message_type' => $this->message->message_type,
                'message_text' => $this->message->message_text,
                'file_path' => $this->message->file_path,
                'seen' => $this->message->seen,
                'created_at' => $this->message->created_at->toISOString(), // ISO format for JavaScript
                'sender' => $this->message->sender,
                'conversation' => $this->message->conversation,
            ]
        ];
        
        return $data;
    }
    
    public function broadcastWhen()
    {
        // Always broadcast
        return true;
    }
    
    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'message.sent';
    }
}