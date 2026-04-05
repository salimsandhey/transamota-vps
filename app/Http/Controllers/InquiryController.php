<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Inquiry;
use App\Models\Conversation;
use App\Models\Product;
use App\Models\Message;

class InquiryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'buyer') {
            // Get inquiries for buyer
            $inquiries = Inquiry::with(['product', 'conversation.seller'])
                ->whereHas('conversation', function ($query) use ($user) {
                    $query->where('buyer_id', $user->id);
                })
                ->latest('added_at')
                ->get();
        } else {
            // Get inquiries for seller
            $inquiries = Inquiry::with(['product', 'conversation.buyer'])
                ->whereHas('conversation', function ($query) use ($user) {
                    $query->where('seller_id', $user->id);
                })
                ->latest('added_at')
                ->get();
        }
        
        return view('inquiries.index', compact('inquiries'));
    }
    
    public function addToInquiry(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);
        
        $user = Auth::user();
        
        // Check if user is a buyer
        if ($user->role !== 'buyer') {
            return response()->json(['error' => 'Only buyers can add products to inquiries.'], 403);
        }
        
        $product = Product::findOrFail($request->product_id);
        
        // Check if buyer is verified
        if (!$user->is_verified) {
            return response()->json(['error' => 'Please verify your account to add products to inquiries.'], 403);
        }
        
        $seller = $product->seller;
        
        // Check if seller is verified
        if (!$seller->is_verified) {
            return response()->json(['error' => 'Seller account is not verified.'], 403);
        }
        
        // Check if conversation already exists
        $conversation = Conversation::where('buyer_id', $user->id)
            ->where('seller_id', $seller->id)
            ->first();
            
        if (!$conversation) {
            $conversation = Conversation::create([
                'buyer_id' => $user->id,
                'seller_id' => $seller->id,
            ]);
        }
        
        // Check if inquiry already exists
        $inquiry = Inquiry::where('conversation_id', $conversation->id)
            ->where('product_id', $product->id)
            ->first();
            
        if (!$inquiry) {
            $inquiry = Inquiry::create([
                'conversation_id' => $conversation->id,
                'product_id' => $product->id,
                'added_at' => now(),
            ]);
            
            // Automatically send product information message
            $this->sendProductInfoMessage($conversation, $product, $user);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Product added to inquiries successfully.',
            'conversation_id' => $conversation->id,
            'redirect_url' => route('inquiries.index')
        ]);
    }
    
    /**
     * Send product information message to the conversation
     */
    private function sendProductInfoMessage($conversation, $product, $user)
    {
        // Create a product information message
        $messageText = "[Product: {$product->name}]";
        
        // Add product details
        $messageText .= "\nPrice: ₹" . ($product->price ? number_format($product->price, 2) : 'N/A');
        $messageText .= "\nMOQ: {$product->moq} {$product->unit}";
        $messageText .= "\nOrigin: {$product->origin_country}";
        
        // Add description if available
        if ($product->description) {
            $messageText .= "\n\nDescription:\n" . substr($product->description, 0, 200);
            if (strlen($product->description) > 200) {
                $messageText .= "...";
            }
        }
        
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'message_type' => 'text',
            'message_text' => $messageText,
        ]);
        
        // Update conversation last message
        $conversation->update([
            'last_message' => 'Product information sent',
            'last_message_at' => now(),
        ]);
        
        // Broadcast the message
        broadcast(new \App\Events\MessageSent($message))->toOthers();
    }
    
    public function removeFromInquiry(Request $request)
    {
        $request->validate([
            'inquiry_id' => 'required|exists:inquiries,id',
        ]);
        
        $user = Auth::user();
        $inquiry = Inquiry::findOrFail($request->inquiry_id);
        
        // Check if user has permission to remove this inquiry
        $conversation = $inquiry->conversation;
        if ($conversation->buyer_id != $user->id && $conversation->seller_id != $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $inquiry->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Product removed from inquiries successfully.'
        ]);
    }
}