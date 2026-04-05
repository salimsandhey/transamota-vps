<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\GroupChat;

class CreateGroupChatsForCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all existing categories
        $categories = Category::all();
        
        // Create group chats for each category if they don't already exist
        foreach ($categories as $category) {
            $groupName = $category->name . ' Group Chat';
            
            // Check if group chat already exists for this category
            $existingGroupChat = GroupChat::where('name', $groupName)->first();
            
            if (!$existingGroupChat) {
                GroupChat::create([
                    'name' => $groupName,
                    'description' => 'Discussion group for ' . $category->name . ' related products and trades',
                    'category' => $category->name,
                ]);
            }
        }
    }
}