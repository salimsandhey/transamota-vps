<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Inquiry;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get real statistics
        $totalActiveProducts = Product::where('seller_id', $user->id)
                                     ->where('status', 'active')
                                     ->count();
        
        $pendingApprovals = Product::where('seller_id', $user->id)
                                 ->where('verification_status', 'pending')
                                 ->count();
        
        $unreadMessages = Message::whereHas('conversation', function($query) use ($user) {
                            $query->where('seller_id', $user->id);
                         })
                         ->where('seen', false)
                         ->where('sender_id', '!=', $user->id)
                         ->count();
        
        $pendingInquiries = Inquiry::whereHas('conversation', function($query) use ($user) {
                              $query->where('seller_id', $user->id);
                          })
                          ->whereDate('added_at', '>=', now()->subDays(7))
                          ->count();
        
        // Get recent conversations
        $recentConversations = $user->sellerConversations()
                                  ->with(['buyer', 'messages'])
                                  ->latest('updated_at')
                                  ->take(3)
                                  ->get();
        
        // Get recent inquiries with product information
        $recentInquiries = Inquiry::with(['product', 'conversation.buyer'])
                                ->whereHas('conversation', function($query) use ($user) {
                                    $query->where('seller_id', $user->id);
                                })
                                ->latest('added_at')
                                ->take(5)
                                ->get();
        
        // Get products needing attention (recently added, pending approval)
        $productsNeedingAttention = Product::where('seller_id', $user->id)
                                         ->whereIn('verification_status', ['pending', 'rejected'])
                                         ->with('category')
                                         ->latest('created_at')
                                         ->take(5)
                                         ->get();
        
        // Get total products count for sidebar
        $totalProducts = Product::where('seller_id', $user->id)->count();
        
        // Share data with all views
        view()->share('totalProducts', $totalProducts);
        
        // Pass data to view
        return view('seller.dashboard', compact(
            'totalActiveProducts',
            'pendingApprovals',
            'unreadMessages',
            'pendingInquiries',
            'recentConversations',
            'recentInquiries',
            'productsNeedingAttention'
        ));
    }
}