<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearViteCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vite:clear-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear Vite cache and provide network access instructions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Clear Vite cache
        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('view:clear');
        
        $this->info('Vite cache cleared successfully!');
        $this->line('');
        $this->info('To access your application from other devices:');
        $this->line('1. Run: php artisan serve --host=0.0.0.0');
        $this->line('2. In another terminal, run: npm run dev --host 0.0.0.0');
        $this->line('3. Access your app at: http://192.168.1.9:8000');
    }
}
