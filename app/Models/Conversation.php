<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Conversation extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'buyer_id',
        'seller_id',
        'last_message',
        'last_message_at',
        'slug'
    ];
    
    protected $casts = [
        'last_message_at' => 'datetime',
    ];
    
    // Generate slug when creating a new conversation
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = self::generateUniqueSlug();
            }
        });
    }
    
    // Generate a unique slug
    public static function generateUniqueSlug()
    {
        do {
            $slug = Str::random(20); // Generate a random 20-character string
        } while (self::where('slug', $slug)->exists());
        
        return $slug;
    }
    
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
    
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
    
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    
    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }
}