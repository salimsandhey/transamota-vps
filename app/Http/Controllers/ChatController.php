<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Product;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'seller') {
            $conversations = $user->sellerConversations()->with(['buyer', 'messages.sender'])->latest('updated_at')->get();
        } else {
            $conversations = $user->buyerConversations()->with(['seller', 'messages.sender'])->latest('updated_at')->get();
        }
        
        return view('chat.index', compact('conversations'));
    }
    
    public function show($slug)
    {
        $user = Auth::user();
        $conversation = Conversation::with(['buyer', 'seller', 'messages' => function($query) {
            $query->oldest();
        }, 'messages.sender'])->where('slug', $slug)->firstOrFail();
        
        // Check if user is part of this conversation
        if ($conversation->buyer_id != $user->id && $conversation->seller_id != $user->id) {
            abort(403);
        }
        
        // Mark messages as seen
        $conversation->messages()->where('sender_id', '!=', $user->id)->update(['seen' => true]);
        
        // Get messages for the view
        $messages = $conversation->messages;
        
        // Remove product display functionality from header
        $product = null;
        
        return view('chat.show', compact('conversation', 'product', 'messages'));
    }
    
    public function createConversation(Request $request)
    {
        $request->validate([
            'seller_id' => 'required|exists:users,id',
            'product_id' => 'nullable|exists:products,id', // Optional product ID
        ]);
        
        $buyer = Auth::user();
        
        // Check if buyer is verified
        if (!$buyer->is_verified) {
            return response()->json(['error' => 'Please verify your account to start chatting with sellers.'], 403);
        }
        
        $seller = User::findOrFail($request->seller_id);
        
        // Check if seller is verified
        if (!$seller->is_verified) {
            return response()->json(['error' => 'Seller account is not verified.'], 403);
        }
        
        // Check if conversation already exists
        $conversation = Conversation::where('buyer_id', $buyer->id)
            ->where('seller_id', $seller->id)
            ->first();
            
        if (!$conversation) {
            $conversation = Conversation::create([
                'buyer_id' => $buyer->id,
                'seller_id' => $seller->id,
            ]);
        }
        
        // If product ID is provided, create an inquiry
        if ($request->product_id) {
            $product = Product::findOrFail($request->product_id);
            
            // Check if inquiry already exists
            $inquiry = \App\Models\Inquiry::where('conversation_id', $conversation->id)
                ->where('product_id', $product->id)
                ->first();
                
            if (!$inquiry) {
                $inquiry = \App\Models\Inquiry::create([
                    'conversation_id' => $conversation->id,
                    'product_id' => $product->id,
                    'added_at' => now(),
                ]);
            }
        }
        
        return response()->json([
            'conversation_id' => $conversation->id,
            'redirect_url' => route('chat.show', $conversation->slug)
        ]);
    }
    
    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'message' => 'required_without:image',
            'image' => 'nullable|image|max:5120', // 5MB max
            'product_id' => 'nullable|exists:products,id', // Optional product ID
        ]);
        
        $user = Auth::user();
        $conversation = Conversation::findOrFail($request->conversation_id);
        
        // Check if user is part of this conversation
        if ($conversation->buyer_id != $user->id && $conversation->seller_id != $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $messageData = [
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'message_type' => 'text',
        ];
        
        // If product ID is provided, prepend product info to message
        if ($request->product_id) {
            $product = Product::findOrFail($request->product_id);
            $messageData['message_text'] = "[Product: {$product->name}] " . $request->message;
        } else {
            $messageData['message_text'] = $request->message;
        }
        
        if ($request->hasFile('image')) {
            $messageData['message_type'] = 'image';
            $path = $request->file('image')->store('chat_images', 'public');
            $messageData['file_path'] = $path;
        }
        
        $message = Message::create($messageData);
        
        // Update conversation last message
        $conversation->update([
            'last_message' => $message->message_text ?? 'Image',
            'last_message_at' => now(),
        ]);
        
        // Broadcast the message to all participants including sender
        error_log('Broadcasting message event: ' . $message->id);
        \Log::info('Broadcasting message event', [
            'message_id' => $message->id,
            'sender_id' => $message->sender_id,
            'conversation_id' => $message->conversation_id,
            'buyer_id' => $conversation->buyer_id,
            'seller_id' => $conversation->seller_id,
            'event_class' => MessageSent::class
        ]);
        \Log::info('About to broadcast MessageSent event');
        broadcast(new MessageSent($message));
        \Log::info('Message event broadcast completed', ['message_id' => $message->id]);
        
        return response()->json([
            'message' => $message->load('sender'),
        ]);
    }
    
    public function getMessages($conversationId)
    {
        $user = Auth::user();
        $conversation = Conversation::findOrFail($conversationId);
        
        // Check if user is part of this conversation
        if ($conversation->buyer_id != $user->id && $conversation->seller_id != $user->id) {
            abort(403);
        }
        
        $messages = $conversation->messages()->with('sender')->oldest()->paginate(20);
        
        return response()->json($messages);
    }
    
    public function getSellerProducts($sellerId)
    {
        $seller = User::findOrFail($sellerId);
        
        // Get seller's approved products
        $products = $seller->products()
            ->where('verification_status', 'approved')
            ->where('status', 'active')
            ->select('id', 'name')
            ->get();
        
        return response()->json($products);
    }
}