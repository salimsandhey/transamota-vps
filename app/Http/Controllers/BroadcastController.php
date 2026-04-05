<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;

class BroadcastController extends Controller
{
    public function authenticate(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response('Unauthorized', 401);
        }
        
        // Get the channel name from the request
        $channelName = $request->input('channel_name');
        
        // Log the authentication attempt
        \Log::info('WebSocket authentication attempt', [
            'user_id' => Auth::id(),
            'channel_name' => $channelName,
            'socket_id' => $request->input('socket_id')
        ]);
        
        // Check if this is a private channel for group chat
        if (strpos($channelName, 'private-group-chat.') === 0) {
            // Extract group chat ID from channel name
            $groupChatId = str_replace('private-group-chat.', '', $channelName);
            
            // Check if user is member of this group chat
            $isMember = \App\Models\GroupChatUser::where('group_chat_id', $groupChatId)
                ->where('user_id', Auth::id())
                ->exists();
                
            if (!$isMember) {
                \Log::warning('WebSocket authentication failed - user not member of group', [
                    'user_id' => Auth::id(),
                    'group_chat_id' => $groupChatId
                ]);
                return response('Forbidden', 403);
            }
            
            \Log::info('WebSocket authentication successful for group chat', [
                'user_id' => Auth::id(),
                'group_chat_id' => $groupChatId
            ]);
        }
        
        if ($request->hasSession()) {
            $request->session()->reflash();
        }
        
        return Broadcast::auth($request);
    }
}