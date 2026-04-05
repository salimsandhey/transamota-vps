<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupChatMessage extends Model
{
    protected $fillable = [
        'group_chat_id',
        'sender_id',
        'message_type',
        'message_text',
        'file_path',
        'seen'
    ];
    
    protected $casts = [
        'seen' => 'boolean',
    ];
    
    public function groupChat()
    {
        return $this->belongsTo(GroupChat::class);
    }
    
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}