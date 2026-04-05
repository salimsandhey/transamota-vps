<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\GroupChat;
use App\Models\GroupChatUser;

class AssignUsersToAllGroupChatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users and group chats
        $users = User::all();
        $groupChats = GroupChat::all();
        
        // Assign all users to all group chats
        foreach ($users as $user) {
            foreach ($groupChats as $groupChat) {
                // Check if the user is already assigned to this group chat
                $existingAssignment = GroupChatUser::where('user_id', $user->id)
                    ->where('group_chat_id', $groupChat->id)
                    ->first();
                
                // If not assigned, create the assignment
                if (!$existingAssignment) {
                    GroupChatUser::create([
                        'user_id' => $user->id,
                        'group_chat_id' => $groupChat->id,
                        'is_admin' => false, // Set to false by default, admins can be set separately
                    ]);
                }
            }
        }
    }
}