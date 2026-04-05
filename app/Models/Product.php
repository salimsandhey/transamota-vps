<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'category_id',
        'subcategory_id',
        'name',
        'slug',
        'description',
        'price',
        'moq',
        'unit',
        'origin_country',
        'status',
        'verification_status',
        'rejection_reason',
        'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'moq' => 'integer',
        'is_featured' => 'boolean',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }
    
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'product_id', 'user_id');
    }
    
    // Scope to get only verified products
    public function scopeVerified($query)
    {
        return $query->where('verification_status', 'approved');
    }
}
