<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'conversation_id',
        'sender_id',
        'message_type',
        'message_text',
        'file_path',
        'seen'
    ];
    
    protected $casts = [
        'seen' => 'boolean',
    ];
    
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
    
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
