<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\User;

class ProductController extends Controller
{
    public function browse(Request $request)
    {
        $query = Product::where('status', 'active')
                        ->where('verification_status', 'approved')
                        ->with('primaryImage', 'category', 'subcategory', 'seller');
        
        // Apply search filter
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
            });
        }
        
        // Apply filters
        if ($request->filled('category')) {
            // If category is passed as a string, find the category ID
            if (!is_numeric($request->category)) {
                $category = Category::where('name', 'like', '%' . $request->category . '%')->first();
                if ($category) {
                    $query->where('category_id', $category->id);
                }
            } else {
                $query->where('category_id', $request->category);
            }
        }
        
        if ($request->filled('subcategory')) {
            $query->where('subcategory_id', $request->subcategory);
        }
        
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        if ($request->filled('country')) {
            $query->where('origin_country', $request->country);
        }
        
        if ($request->filled('verified_seller')) {
            $query->whereHas('seller', function ($q) {
                $q->where('is_verified', true);
            });
        }
        
        // Apply sorting
        switch ($request->sort) {
            case 'popular':
                // For now, we'll just order by ID as a placeholder
                $query->orderBy('id', 'desc');
                break;
            case 'featured':
                $query->where('is_featured', true)->orderBy('id', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        // Get categories for filter
        $categories = Category::all();
        
        // Get countries for filter
        $countries = Product::where('status', 'active')
                           ->where('verification_status', 'approved')
                           ->distinct()
                           ->pluck('origin_country');
        
        $products = $query->paginate(12);
        
        return view('public.products.browse', compact('products', 'categories', 'countries'));
    }
    
    public function show($id)
    {
        $product = Product::where('id', $id)
                         ->where('status', 'active')
                         ->where('verification_status', 'approved')
                         ->with('images', 'category', 'subcategory', 'seller')
                         ->firstOrFail();
                         
        // Get related products from the same category (limit to 4)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->where('verification_status', 'approved')
            ->with('images')
            ->take(4)
            ->get();
            
        // If no related products in the same category, get fallback products
        if ($relatedProducts->count() == 0) {
            $relatedProducts = Product::where('id', '!=', $product->id)
                ->where('status', 'active')
                ->where('verification_status', 'approved')
                ->with('images')
                ->take(4)
                ->get();
        }
        
        // Get seller statistics
        $sellerProductCount = Product::where('seller_id', $product->seller->id)
            ->where('status', 'active')
            ->where('verification_status', 'approved')
            ->count();
            
        return view('public.products.show', compact('product', 'relatedProducts', 'sellerProductCount'));
    }
    
    public function getSubcategories(Request $request)
    {
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();
        return response()->json($subcategories);
    }
}