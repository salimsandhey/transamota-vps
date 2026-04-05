<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inquiry extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'conversation_id',
        'product_id',
        'notes',
        'added_at'
    ];
    
    protected $casts = [
        'added_at' => 'datetime',
    ];
    
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}