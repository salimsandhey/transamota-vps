<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Conversation;

class GenerateConversationSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-conversation-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate slugs for existing conversations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating slugs for conversations...');
        
        $conversations = Conversation::whereNull('slug')->get();
        
        $this->output->progressStart($conversations->count());
        
        foreach ($conversations as $conversation) {
            $conversation->slug = Conversation::generateUniqueSlug();
            $conversation->save();
            $this->output->progressAdvance();
        }
        
        $this->output->progressFinish();
        
        $this->info('Successfully generated slugs for ' . $conversations->count() . ' conversations.');
    }
}