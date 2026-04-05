<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupChatUser extends Model
{
    protected $fillable = [
        'group_chat_id',
        'user_id',
        'is_admin'
    ];
    
    public function groupChat()
    {
        return $this->belongsTo(GroupChat::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
