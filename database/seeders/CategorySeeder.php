<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics', 'description' => 'Electronic devices and components'],
            ['name' => 'Clothing', 'description' => 'Apparel and fashion items'],
            ['name' => 'Home & Garden', 'description' => 'Home improvement and garden supplies'],
            ['name' => 'Automotive', 'description' => 'Car parts and accessories'],
            ['name' => 'Sports & Outdoors', 'description' => 'Sporting goods and outdoor equipment'],
            ['name' => 'Beauty & Personal Care', 'description' => 'Cosmetics and personal care products'],
            ['name' => 'Industrial & Scientific', 'description' => 'Industrial equipment and supplies'],
            ['name' => 'Food & Beverage', 'description' => 'Food products and beverages'],
        ];

        foreach ($categories as $categoryData) {
            Category::create([
                'name' => $categoryData['name'],
                'slug' => Str::slug($categoryData['name']),
                'description' => $categoryData['description'],
            ]);
        }
    }
}