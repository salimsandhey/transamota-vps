<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Subcategory;

class CleanAndRepopulateCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing categories and subcategories
        Subcategory::truncate();
        Category::truncate();
        
        // Define new categories with SVG icons
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices and components including smartphones, laptops, and accessories',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" /></svg>',
                'subcategories' => [
                    ['name' => 'Smartphones', 'description' => 'Mobile phones and smartphones'],
                    ['name' => 'Laptops', 'description' => 'Notebooks and laptops'],
                    ['name' => 'Tablets', 'description' => 'Tablet computers and accessories'],
                    ['name' => 'Cameras', 'description' => 'Digital cameras and photography equipment'],
                    ['name' => 'Audio Equipment', 'description' => 'Speakers, headphones, and audio devices'],
                    ['name' => 'Gaming Consoles', 'description' => 'Video game consoles and accessories'],
                ]
            ],
            [
                'name' => 'Fashion',
                'description' => 'Clothing, shoes, and fashion accessories for men, women, and children',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>',
                'subcategories' => [
                    ['name' => 'Men\'s Clothing', 'description' => 'Clothing for men'],
                    ['name' => 'Women\'s Clothing', 'description' => 'Clothing for women'],
                    ['name' => 'Children\'s Clothing', 'description' => 'Clothing for children'],
                    ['name' => 'Shoes', 'description' => 'Footwear for all genders'],
                    ['name' => 'Bags & Wallets', 'description' => 'Handbags, wallets, and accessories'],
                    ['name' => 'Jewelry', 'description' => 'Necklaces, rings, and other jewelry'],
                ]
            ],
            [
                'name' => 'Home & Garden',
                'description' => 'Home improvement, furniture, and garden supplies',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>',
                'subcategories' => [
                    ['name' => 'Furniture', 'description' => 'Living room, bedroom, and office furniture'],
                    ['name' => 'Kitchen & Dining', 'description' => 'Cookware, dinnerware, and kitchen appliances'],
                    ['name' => 'Home Decor', 'description' => 'Decorative items and home accents'],
                    ['name' => 'Garden Tools', 'description' => 'Gardening equipment and tools'],
                    ['name' => 'Lighting', 'description' => 'Light fixtures and lamps'],
                    ['name' => 'Bedding', 'description' => 'Sheets, comforters, and bedding accessories'],
                ]
            ],
            [
                'name' => 'Automotive',
                'description' => 'Car parts, accessories, and automotive equipment',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>',
                'subcategories' => [
                    ['name' => 'Car Parts', 'description' => 'Replacement parts for vehicles'],
                    ['name' => 'Motorcycle Parts', 'description' => 'Parts and accessories for motorcycles'],
                    ['name' => 'Car Accessories', 'description' => 'Interior and exterior vehicle accessories'],
                    ['name' => 'Tires & Wheels', 'description' => 'Tires, rims, and wheel accessories'],
                    ['name' => 'Tools & Equipment', 'description' => 'Automotive tools and diagnostic equipment'],
                    ['name' => 'Oils & Fluids', 'description' => 'Motor oils, coolants, and other automotive fluids'],
                ]
            ],
            [
                'name' => 'Sports & Outdoors',
                'description' => 'Sporting goods, outdoor equipment, and fitness products',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" /></svg>',
                'subcategories' => [
                    ['name' => 'Fitness Equipment', 'description' => 'Gym equipment and home fitness products'],
                    ['name' => 'Team Sports', 'description' => 'Equipment for basketball, soccer, football, and more'],
                    ['name' => 'Outdoor Recreation', 'description' => 'Camping, hiking, and outdoor activity gear'],
                    ['name' => 'Water Sports', 'description' => 'Swimming, surfing, and water activity equipment'],
                    ['name' => 'Cycling', 'description' => 'Bicycles, parts, and cycling accessories'],
                    ['name' => 'Winter Sports', 'description' => 'Skiing, snowboarding, and winter activity gear'],
                ]
            ],
            [
                'name' => 'Beauty & Personal Care',
                'description' => 'Cosmetics, skincare, and personal care products',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
                'subcategories' => [
                    ['name' => 'Skincare', 'description' => 'Face and body skincare products'],
                    ['name' => 'Hair Care', 'description' => 'Shampoos, conditioners, and hair treatments'],
                    ['name' => 'Makeup', 'description' => 'Cosmetics and makeup products'],
                    ['name' => 'Fragrances', 'description' => 'Perfumes and colognes'],
                    ['name' => 'Personal Hygiene', 'description' => 'Toothpaste, deodorants, and hygiene products'],
                    ['name' => 'Tools & Accessories', 'description' => 'Beauty tools and accessories'],
                ]
            ],
            [
                'name' => 'Industrial & Scientific',
                'description' => 'Industrial equipment, laboratory supplies, and scientific instruments',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>',
                'subcategories' => [
                    ['name' => 'Lab Equipment', 'description' => 'Laboratory instruments and supplies'],
                    ['name' => 'Industrial Supplies', 'description' => 'Manufacturing and industrial materials'],
                    ['name' => 'Safety Equipment', 'description' => 'Protective gear and safety supplies'],
                    ['name' => 'Test Instruments', 'description' => 'Measuring and testing equipment'],
                    ['name' => 'Robotics', 'description' => 'Robotic components and systems'],
                    ['name' => '3D Printing', 'description' => '3D printers, filament, and accessories'],
                ]
            ],
            [
                'name' => 'Food & Beverage',
                'description' => 'Food products, beverages, and culinary supplies',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h6a3 3 0 013 3v12a3 3 0 01-3 3H6a3 3 0 01-3-3V6a3 3 0 013-3h3zm-2 9h10m-5 5v-2" /></svg>',
                'subcategories' => [
                    ['name' => 'Snacks & Confectionery', 'description' => 'Chips, candies, and sweet treats'],
                    ['name' => 'Beverages', 'description' => 'Soft drinks, juices, and energy drinks'],
                    ['name' => 'Cooking Ingredients', 'description' => 'Spices, oils, and cooking essentials'],
                    ['name' => 'Dairy Products', 'description' => 'Milk, cheese, and dairy items'],
                    ['name' => 'Frozen Foods', 'description' => 'Frozen meals and ice cream'],
                    ['name' => 'Bakery Items', 'description' => 'Bread, pastries, and baked goods'],
                ]
            ],
            [
                'name' => 'Health & Medical',
                'description' => 'Healthcare products, medical supplies, and wellness items',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>',
                'subcategories' => [
                    ['name' => 'Medical Supplies', 'description' => 'First aid kits, bandages, and medical equipment'],
                    ['name' => 'Vitamins & Supplements', 'description' => 'Dietary supplements and vitamins'],
                    ['name' => 'Personal Care', 'description' => 'Hygiene and personal wellness products'],
                    ['name' => 'Mobility Aids', 'description' => 'Wheelchairs, walkers, and mobility equipment'],
                    ['name' => 'Health Monitoring', 'description' => 'Blood pressure monitors and health devices'],
                    ['name' => 'Orthopedic Products', 'description' => 'Braces, supports, and orthopedic supplies'],
                ]
            ],
            [
                'name' => 'Toys & Games',
                'description' => 'Toys, games, and entertainment products for all ages',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
                'subcategories' => [
                    ['name' => 'Action Figures', 'description' => 'Collectible figures and character toys'],
                    ['name' => 'Board Games', 'description' => 'Strategy games, puzzles, and board games'],
                    ['name' => 'Educational Toys', 'description' => 'Learning toys and STEM education products'],
                    ['name' => 'Outdoor Play', 'description' => 'Sports equipment and outdoor toys'],
                    ['name' => 'Electronic Toys', 'description' => 'Remote control toys and electronic games'],
                    ['name' => 'Dolls & Accessories', 'description' => 'Dolls, stuffed animals, and accessories'],
                ]
            ],
            [
                'name' => 'Books & Media',
                'description' => 'Books, magazines, music, and digital media',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>',
                'subcategories' => [
                    ['name' => 'Fiction Books', 'description' => 'Novels, stories, and fictional literature'],
                    ['name' => 'Non-Fiction Books', 'description' => 'Educational, biographical, and informative books'],
                    ['name' => 'Children\'s Books', 'description' => 'Books for children of all ages'],
                    ['name' => 'Music & Audio', 'description' => 'CDs, vinyl records, and audio products'],
                    ['name' => 'Movies & TV', 'description' => 'DVDs, Blu-rays, and video content'],
                    ['name' => 'Magazines', 'description' => 'Periodicals and subscription publications'],
                ]
            ],
            [
                'name' => 'Office Supplies',
                'description' => 'Stationery, office equipment, and business supplies',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>',
                'subcategories' => [
                    ['name' => 'Writing Instruments', 'description' => 'Pens, pencils, and writing tools'],
                    ['name' => 'Paper Products', 'description' => 'Notebooks, printer paper, and paper supplies'],
                    ['name' => 'Desk Accessories', 'description' => 'Organizers, staplers, and desk items'],
                    ['name' => 'Filing & Storage', 'description' => 'Folders, filing cabinets, and storage solutions'],
                    ['name' => 'Presentation Supplies', 'description' => 'Whiteboards, markers, and presentation tools'],
                    ['name' => 'Office Furniture', 'description' => 'Chairs, desks, and office furniture'],
                ]
            ]
        ];

        // Create categories and their subcategories
        foreach ($categories as $categoryData) {
            // Create category
            $category = Category::create([
                'name' => $categoryData['name'],
                'slug' => Str::slug($categoryData['name']),
                'description' => $categoryData['description'],
                'icon' => $categoryData['icon'],
            ]);
            
            // Create subcategories for this category
            foreach ($categoryData['subcategories'] as $subcategoryData) {
                Subcategory::create([
                    'category_id' => $category->id,
                    'name' => $subcategoryData['name'],
                    'slug' => Str::slug($subcategoryData['name']),
                    'description' => $subcategoryData['description'],
                ]);
            }
        }
    }
}