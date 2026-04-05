<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Subcategory;
use App\Models\Category;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Electronics subcategories
        $electronics = Category::where('name', 'Electronics')->first();
        if ($electronics) {
            $subcategories = [
                ['name' => 'Smartphones', 'description' => 'Mobile phones and smartphones'],
                ['name' => 'Laptops', 'description' => 'Notebooks and laptops'],
                ['name' => 'Cameras', 'description' => 'Digital cameras and accessories'],
                ['name' => 'Audio Equipment', 'description' => 'Speakers, headphones, and audio devices'],
            ];

            foreach ($subcategories as $subcategoryData) {
                Subcategory::create([
                    'category_id' => $electronics->id,
                    'name' => $subcategoryData['name'],
                    'slug' => Str::slug($subcategoryData['name']),
                    'description' => $subcategoryData['description'],
                ]);
            }
        }

        // Clothing subcategories
        $clothing = Category::where('name', 'Clothing')->first();
        if ($clothing) {
            $subcategories = [
                ['name' => 'Men\'s Clothing', 'description' => 'Clothing for men'],
                ['name' => 'Women\'s Clothing', 'description' => 'Clothing for women'],
                ['name' => 'Children\'s Clothing', 'description' => 'Clothing for children'],
                ['name' => 'Shoes', 'description' => 'Footwear for all genders'],
            ];

            foreach ($subcategories as $subcategoryData) {
                Subcategory::create([
                    'category_id' => $clothing->id,
                    'name' => $subcategoryData['name'],
                    'slug' => Str::slug($subcategoryData['name']),
                    'description' => $subcategoryData['description'],
                ]);
            }
        }
    }
}