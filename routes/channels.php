<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;
use App\Models\Conversation;
use App\Models\GroupChat;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen on the channel.
|
*/

Broadcast::channel('chat.{userId}', function ($user, $userId) {
    \Log::info('Channel authorization check', [
        'user_id' => $user->id,
        'requested_user_id' => $userId,
        'authorized' => (int) $user->id === (int) $userId
    ]);
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    \Log::info('Conversation channel authorization check', [
        'user_id' => $user->id,
        'conversation_id' => $conversationId
    ]);
    
    $conversation = Conversation::find($conversationId);
    
    if (!$conversation) {
        \Log::info('Conversation not found', ['conversation_id' => $conversationId]);
        return false;
    }
    
    $isAuthorized = ($user->id === $conversation->buyer_id || $user->id === $conversation->seller_id);
    \Log::info('Conversation channel authorization result', [
        'user_id' => $user->id,
        'conversation_id' => $conversationId,
        'authorized' => $isAuthorized
    ]);
    
    return $isAuthorized;
});

// Add authorization for group chat channels
Broadcast::channel('group-chat.{groupChatId}', function ($user, $groupChatId) {
    \Log::info('Group chat channel authorization check', [
        'user_id' => $user->id,
        'group_chat_id' => $groupChatId
    ]);
    
    // Check if user is a member of this group chat
    $isMember = \App\Models\GroupChatUser::where('group_chat_id', $groupChatId)
        ->where('user_id', $user->id)
        ->exists();
        
    \Log::info('Group chat channel authorization result', [
        'user_id' => $user->id,
        'group_chat_id' => $groupChatId,
        'authorized' => $isMember
    ]);
    
    return $isMember;
});