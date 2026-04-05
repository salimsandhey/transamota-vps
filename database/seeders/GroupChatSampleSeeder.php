<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GroupChat;
use App\Models\User;

class GroupChatSampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some sample users
        $users = User::where('is_verified', true)->take(10)->get();
        
        if ($users->count() < 2) {
            echo "Not enough verified users to create group chats.\n";
            return;
        }
        
        // Create sample group chats
        $groupChats = [
            [
                'name' => 'Grains & Pulses Traders',
                'description' => 'Discussion forum for grains and pulses traders',
                'category' => 'Grains & Pulses'
            ],
            [
                'name' => 'Spices Marketplace',
                'description' => 'Connect with spice suppliers and buyers',
                'category' => 'Spices'
            ],
            [
                'name' => 'Fresh Produce Network',
                'description' => 'Fresh fruits and vegetables trading community',
                'category' => 'Fruits & Vegetables'
            ],
            [
                'name' => 'Handicrafts Artisans',
                'description' => 'Platform for handicrafts artisans and collectors',
                'category' => 'Handicrafts'
            ],
            [
                'name' => 'Kitchen Essentials',
                'description' => 'Trading hub for kitchen and household items',
                'category' => 'Kitchen & Household Items'
            ]
        ];
        
        foreach ($groupChats as $groupChatData) {
            $groupChat = GroupChat::create($groupChatData);
            
            // Attach random users to each group chat (3-6 users per group)
            $randomUsers = $users->random(rand(3, min(6, $users->count())));
            $groupChat->users()->attach($randomUsers, ['is_admin' => false]);
            
            // Make the first user an admin
            if ($randomUsers->count() > 0) {
                $groupChat->users()->updateExistingPivot($randomUsers->first()->id, ['is_admin' => true]);
            }
            
            echo "Created group chat: {$groupChat->name} with {$randomUsers->count()} members\n";
        }
        
        echo "Group chat seeding completed!\n";
    }
}