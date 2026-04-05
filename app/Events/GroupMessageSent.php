<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\GroupChatMessage;

class GroupMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct(GroupChatMessage $message)
    {
        $this->message = $message->load(['sender', 'groupChat']);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        \Log::info('Broadcasting group message to group chat channel', [
            'group_chat_id' => $this->message->group_chat_id,
            'message_id' => $this->message->id,
            'channel_name' => 'group-chat.' . $this->message->group_chat_id,
            'event_class' => static::class
        ]);
        
        // Broadcast to group chat channel (Echo will automatically prepend 'private-')
        return [
            new PrivateChannel('group-chat.' . $this->message->group_chat_id),
        ];
    }
    
    public function broadcastWith()
    {
        // Add formatted timestamp to the broadcast data
        $data = [
            'message' => [
                'id' => $this->message->id,
                'group_chat_id' => $this->message->group_chat_id,
                'sender_id' => $this->message->sender_id,
                'message_type' => $this->message->message_type,
                'message_text' => $this->message->message_text,
                'file_path' => $this->message->file_path,
                'seen' => $this->message->seen,
                'created_at' => $this->message->created_at->toISOString(), // ISO format for JavaScript
                'sender' => $this->message->sender,
                'groupChat' => $this->message->groupChat,
            ]
        ];
        
        \Log::info('Broadcasting with data', $data);
        
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
        $eventName = 'group.message.sent';
        
        \Log::info('Broadcasting as event name', [
            'event_name' => $eventName,
            'is_string' => is_string($eventName),
            'event_length' => strlen($eventName)
        ]);
        
        // Return the event name as a string
        return $eventName;
    }
}