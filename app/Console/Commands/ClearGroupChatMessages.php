<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GroupChatMessage;

class ClearGroupChatMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'group-chat:clear-messages {--force : Force the operation without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all messages from group chats';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Confirm with user unless --force option is used
        if (!$this->option('force')) {
            if (!$this->confirm('This will permanently delete ALL group chat messages. Are you sure you want to continue?')) {
                $this->info('Operation cancelled.');
                return;
            }
        }

        try {
            // Count existing messages
            $messageCount = GroupChatMessage::count();
            
            if ($messageCount === 0) {
                $this->info('No group chat messages found in the database.');
                return;
            }
            
            $this->info("Found {$messageCount} group chat messages.");
            
            // Delete all group chat messages
            GroupChatMessage::truncate();
            
            $this->info("Successfully deleted all {$messageCount} group chat messages!");
            
        } catch (\Exception $e) {
            $this->error('An error occurred while deleting group chat messages: ' . $e->getMessage());
            return 1;
        }
    }
}