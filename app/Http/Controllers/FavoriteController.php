<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle(Request $request, Product $product)
    {
        $user = Auth::user();
        
        // Check if the product is already favorited by the user
        $favorite = Favorite::where('user_id', $user->id)
                            ->where('product_id', $product->id)
                            ->first();
        
        if ($favorite) {
            // If already favorited, remove it
            $favorite->delete();
            return response()->json(['favorited' => false, 'message' => 'Removed from favorites']);
        } else {
            // If not favorited, add it
            Favorite::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            return response()->json(['favorited' => true, 'message' => 'Added to favorites']);
        }
    }
    
    public function index()
    {
        $favorites = Auth::user()->favorites()->with('product.images', 'product.seller')->get();
        return view('favorites.index', compact('favorites'));
    }
}