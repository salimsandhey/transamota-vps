<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupChat extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category'
    ];
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'group_chat_users')
                    ->withPivot('is_admin')
                    ->withTimestamps();
    }
    
    public function messages()
    {
        return $this->hasMany(GroupChatMessage::class);
    }
}