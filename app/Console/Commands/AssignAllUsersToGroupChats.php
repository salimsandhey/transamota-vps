<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\GroupChat;

class AssignAllUsersToGroupChats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:assign-to-group-chats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign all existing users to all group chats';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to assign all users to group chats...');
        
        // Get all users
        $users = User::all();
        $this->info("Found {$users->count()} users.");
        
        // Get all group chats
        $groupChats = GroupChat::all();
        $this->info("Found {$groupChats->count()} group chats.");
        
        $assignedCount = 0;
        
        // Process each user
        foreach ($users as $user) {
            // Assign user to all group chats
            foreach ($groupChats as $groupChat) {
                // Check if user is already assigned to this group chat
                $existingAssignment = $groupChat->users()->where('user_id', $user->id)->first();
                
                // If not assigned, create the assignment
                if (!$existingAssignment) {
                    $groupChat->users()->attach($user->id, ['is_admin' => false]);
                    $assignedCount++;
                }
            }
        }
        
        $this->info("Successfully assigned users to group chats. Total new assignments: {$assignedCount}");
        $this->info('Done!');
    }
}