<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function browse()
    {
        $products = Product::where('status', 'active')->with('primaryImage')->get();
        return view('buyer.products.browse', compact('products'));
    }
    
    public function show($id)
    {
        $product = Product::where('id', $id)->where('status', 'active')->with('images', 'category', 'subcategory')->firstOrFail();
        return view('buyer.products.show', compact('product'));
    }
}