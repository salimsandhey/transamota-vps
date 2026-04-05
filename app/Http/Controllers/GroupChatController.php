<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\GroupChat;
use App\Models\GroupChatUser;
use App\Models\GroupChatMessage;
use App\Events\GroupMessageSent;

class GroupChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            // Redirect to login if not authenticated
            return redirect()->route('login');
        }
        
        // Get all group chats that the user belongs to
        $groupChats = GroupChat::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with('users')->get();
        
        return view('group-chat.index', compact('groupChats'));
    }
    
    public function show($id)
    {
        $user = Auth::user();
        
        if (!$user) {
            // Redirect to login if not authenticated
            return redirect()->route('login');
        }
        
        // Find the group chat and ensure user is a member
        $groupChat = GroupChat::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with('users')->findOrFail($id);
        
        // Get messages for this group chat
        $messages = GroupChatMessage::where('group_chat_id', $groupChat->id)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();
        
        return view('group-chat.show', compact('groupChat', 'messages'));
    }
    
    public function sendMessage(Request $request, $groupChatId)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'message' => 'required|string|max:1000',
            ]);
            
            $user = Auth::user();
            
            // Check if user is member of the group chat
            $groupChat = GroupChat::whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->findOrFail($groupChatId);
            
            // Create the message
            $messageData = [
                'group_chat_id' => $groupChat->id,
                'sender_id' => $user->id,
                'message_type' => 'text',
                'message_text' => $validated['message'],
            ];
            
            $message = GroupChatMessage::create($messageData);
            
            // Load relationships for the response
            $message->load('sender');
            
            // Log before broadcasting
            \Log::info('About to broadcast GroupMessageSent event', [
                'message_id' => $message->id,
                'group_chat_id' => $groupChat->id,
                'sender_id' => $user->id
            ]);
            
            // Broadcast the message to all participants INCLUDING sender
            // This ensures real-time delivery for all users including the sender
            $event = new GroupMessageSent($message);
            \Log::info('Created GroupMessageSent event instance', [
                'event_class' => get_class($event),
                'broadcast_as' => method_exists($event, 'broadcastAs') ? $event->broadcastAs() : 'method_not_found'
            ]);
            
            broadcast($event);
            
            // Log after broadcasting
            \Log::info('GroupMessageSent event broadcast completed', [
                'message_id' => $message->id
            ]);
            
            return response()->json([
                'status' => 'success',
                'message' => $message,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error sending group chat message: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'group_chat_id' => $groupChatId,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send message. Please try again.'
            ], 500);
        }
    }
    
    public function getMessages($groupChatId)
    {
        try {
            $user = Auth::user();
            
            // Check if user is member of the group chat
            $groupChat = GroupChat::whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->findOrFail($groupChatId);
            
            $messages = GroupChatMessage::where('group_chat_id', $groupChat->id)
                ->with('sender')
                ->orderBy('created_at', 'asc')
                ->paginate(20);
            
            return response()->json($messages);
        } catch (\Exception $e) {
            \Log::error('Error fetching group chat messages: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'group_chat_id' => $groupChatId,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to load messages. Please try again.'
            ], 500);
        }
    }
}