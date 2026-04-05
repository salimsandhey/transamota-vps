<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_type',
        'product_categories',
        'products_offered',
        'products_interested',
        'buying_frequency',
        'website',
        'gst_no',
        'verification_doc',
        'verification_doc_type',
        'verified_by_admin',
    ];

    protected $casts = [
        'product_categories' => 'array',
        'verified_by_admin' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function getDocumentTypeNameAttribute()
    {
        $types = [
            'business_registration' => 'Business Registration Certificate',
            'government_id' => 'Government ID',
            'bank_details' => 'Bank Account Details',
            'gst_certificate' => 'GST Registration Certificate',
            'product_catalog' => 'Product Catalog',
            'other' => 'Other Document'
        ];
        
        return $types[$this->verification_doc_type] ?? 'Unknown Document';
    }
}