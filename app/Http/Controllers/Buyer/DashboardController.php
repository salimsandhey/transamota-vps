<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Inquiry;
use App\Models\Favorite;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get real statistics
        $totalOrders = Inquiry::whereHas('conversation', function($query) use ($user) {
            $query->where('buyer_id', $user->id);
        })->count();
        
        $totalSpent = 0; // Placeholder - would need order data to calculate actual spent
        
        $unreadMessages = Message::whereHas('conversation', function($query) use ($user) {
            $query->where('buyer_id', $user->id);
        })
        ->where('seen', false)
        ->where('sender_id', '!=', $user->id)
        ->count();
        
        $savedProducts = Favorite::where('user_id', $user->id)->count();
        
        // Get recent conversations
        $recentConversations = $user->buyerConversations()
                                  ->with(['seller', 'messages'])
                                  ->latest('updated_at')
                                  ->take(3)
                                  ->get();
        
        // Get recent inquiries with product information
        $recentInquiries = Inquiry::with(['product', 'conversation.seller'])
                                ->whereHas('conversation', function($query) use ($user) {
                                    $query->where('buyer_id', $user->id);
                                })
                                ->latest('added_at')
                                ->take(5)
                                ->get();
        
        // Get saved products
        $savedProductsList = Favorite::with('product.category')
                                   ->where('user_id', $user->id)
                                   ->latest()
                                   ->take(5)
                                   ->get()
                                   ->map(function($favorite) {
                                       return $favorite->product;
                                   });
        
        // Get recently viewed products (would need a product_views table to implement properly)
        $recentlyViewed = collect(); // Placeholder
        
        // Relationships are already loaded via with() clause above
        
        // Share data with all views
        view()->share('savedProducts', $savedProducts);
        
        // Pass data to view
        return view('buyer.dashboard', compact(
            'totalOrders',
            'totalSpent',
            'unreadMessages',
            'savedProducts',
            'recentConversations',
            'recentInquiries',
            'savedProductsList',
            'recentlyViewed'
        ));
    }
}