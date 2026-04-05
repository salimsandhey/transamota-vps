<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GroupChat;
use App\Models\GroupChatUser;
use App\Models\User;

class GroupChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample group chats
        $electronicsGroup = GroupChat::create([
            'name' => 'Electronics Trading',
            'description' => 'Group for buying and selling electronics',
            'category' => 'Electronics'
        ]);
        
        $fashionGroup = GroupChat::create([
            'name' => 'Fashion Marketplace',
            'description' => 'Group for fashion products trading',
            'category' => 'Fashion'
        ]);
        
        // Get some sample users
        $seller = User::where('role', 'seller')->first();
        $buyer = User::where('role', 'buyer')->first();
        
        if ($seller && $buyer) {
            // Add users to electronics group
            GroupChatUser::create([
                'group_chat_id' => $electronicsGroup->id,
                'user_id' => $seller->id,
                'is_admin' => true
            ]);
            
            GroupChatUser::create([
                'group_chat_id' => $electronicsGroup->id,
                'user_id' => $buyer->id,
                'is_admin' => false
            ]);
            
            // Add users to fashion group
            GroupChatUser::create([
                'group_chat_id' => $fashionGroup->id,
                'user_id' => $seller->id,
                'is_admin' => false
            ]);
            
            GroupChatUser::create([
                'group_chat_id' => $fashionGroup->id,
                'user_id' => $buyer->id,
                'is_admin' => true
            ]);
        }
    }
}
