<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use App\Models\Subcategory;

class ShowCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'categories:show';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show all categories and their subcategories';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $categories = Category::with('subcategories')->get();
        
        $this->info('Categories and Subcategories:');
        $this->line('');
        
        foreach ($categories as $category) {
            $this->info($category->name . ' (' . $category->subcategories->count() . ' subcategories)');
            foreach ($category->subcategories as $subcategory) {
                $this->line('  - ' . $subcategory->name);
            }
            $this->line('');
        }
        
        $this->info('Total Categories: ' . $categories->count());
        $totalSubcategories = Subcategory::count();
        $this->info('Total Subcategories: ' . $totalSubcategories);
    }
}