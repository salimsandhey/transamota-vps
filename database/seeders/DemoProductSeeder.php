<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Str;

class DemoProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the seller user
        $seller = User::where('email', 'seller@example.com')->first();
        
        if (!$seller) {
            echo "No seller user found. Please run SellerUserSeeder first.\n";
            return;
        }
        
        // Get categories and subcategories
        $electronics = Category::where('name', 'Electronics')->first();
        $clothing = Category::where('name', 'Clothing')->first();
        $homeGarden = Category::where('name', 'Home & Garden')->first();
        $sports = Category::where('name', 'Sports & Outdoors')->first();
        $food = Category::where('name', 'Food & Beverage')->first();
        
        // Get subcategories
        $smartphones = $electronics ? Subcategory::where('name', 'Smartphones')->where('category_id', $electronics->id)->first() : null;
        $laptops = $electronics ? Subcategory::where('name', 'Laptops')->where('category_id', $electronics->id)->first() : null;
        $mensClothing = $clothing ? Subcategory::where('name', "Men's Clothing")->where('category_id', $clothing->id)->first() : null;
        $womensClothing = $clothing ? Subcategory::where('name', "Women's Clothing")->where('category_id', $clothing->id)->first() : null;
        
        // Demo products data
        $products = [
            [
                'name' => 'iPhone 15 Pro Max',
                'description' => 'Latest iPhone with advanced camera system and A17 Pro chip',
                'price' => 1199.99,
                'moq' => 1,
                'unit' => 'piece',
                'origin_country' => 'USA',
                'category_id' => $electronics ? $electronics->id : null,
                'subcategory_id' => $smartphones ? $smartphones->id : null,
                'status' => 'active',
                'verification_status' => 'approved'
            ],
            [
                'name' => 'MacBook Air M2',
                'description' => 'Ultra-thin laptop with M2 chip and 13.6-inch Liquid Retina display',
                'price' => 1099.00,
                'moq' => 1,
                'unit' => 'piece',
                'origin_country' => 'USA',
                'category_id' => $electronics ? $electronics->id : null,
                'subcategory_id' => $laptops ? $laptops->id : null,
                'status' => 'active',
                'verification_status' => 'approved'
            ],
            [
                'name' => 'Samsung 4K Smart TV 55"',
                'description' => 'Crystal UHD 4K Smart TV with Quantum Dot technology',
                'price' => 699.99,
                'moq' => 1,
                'unit' => 'piece',
                'origin_country' => 'South Korea',
                'category_id' => $electronics ? $electronics->id : null,
                'subcategory_id' => null,
                'status' => 'active',
                'verification_status' => 'approved'
            ],
            [
                'name' => 'Men\'s Premium Cotton T-Shirt',
                'description' => '100% premium cotton t-shirt with comfortable fit',
                'price' => 24.99,
                'moq' => 10,
                'unit' => 'piece',
                'origin_country' => 'Bangladesh',
                'category_id' => $clothing ? $clothing->id : null,
                'subcategory_id' => $mensClothing ? $mensClothing->id : null,
                'status' => 'active',
                'verification_status' => 'approved'
            ],
            [
                'name' => 'Women\'s Summer Dress',
                'description' => 'Lightweight summer dress with floral pattern',
                'price' => 39.99,
                'moq' => 5,
                'unit' => 'piece',
                'origin_country' => 'India',
                'category_id' => $clothing ? $clothing->id : null,
                'subcategory_id' => $womensClothing ? $womensClothing->id : null,
                'status' => 'active',
                'verification_status' => 'approved'
            ],
            [
                'name' => 'Garden Tool Set',
                'description' => 'Complete set of 5 garden tools including shovel, rake, and pruners',
                'price' => 49.99,
                'moq' => 1,
                'unit' => 'set',
                'origin_country' => 'China',
                'category_id' => $homeGarden ? $homeGarden->id : null,
                'subcategory_id' => null,
                'status' => 'active',
                'verification_status' => 'approved'
            ],
            [
                'name' => 'Wireless Bluetooth Headphones',
                'description' => 'Noise-cancelling wireless headphones with 30-hour battery life',
                'price' => 129.99,
                'moq' => 1,
                'unit' => 'piece',
                'origin_country' => 'China',
                'category_id' => $electronics ? $electronics->id : null,
                'subcategory_id' => null,
                'status' => 'active',
                'verification_status' => 'approved'
            ],
            [
                'name' => 'Organic Coffee Beans 1kg',
                'description' => 'Premium organic coffee beans from Colombia, medium roast',
                'price' => 19.99,
                'moq' => 5,
                'unit' => 'kg',
                'origin_country' => 'Colombia',
                'category_id' => $food ? $food->id : null,
                'subcategory_id' => null,
                'status' => 'active',
                'verification_status' => 'approved'
            ],
            [
                'name' => 'Fitness Tracker Smart Watch',
                'description' => 'Waterproof smartwatch with heart rate monitor and GPS',
                'price' => 79.99,
                'moq' => 1,
                'unit' => 'piece',
                'origin_country' => 'China',
                'category_id' => $electronics ? $electronics->id : null,
                'subcategory_id' => null,
                'status' => 'active',
                'verification_status' => 'approved'
            ],
            [
                'name' => 'Yoga Mat Premium',
                'description' => 'Eco-friendly non-slip yoga mat with carrying strap',
                'price' => 29.99,
                'moq' => 1,
                'unit' => 'piece',
                'origin_country' => 'India',
                'category_id' => $sports ? $sports->id : null,
                'subcategory_id' => null,
                'status' => 'active',
                'verification_status' => 'approved'
            ],
            [
                'name' => 'LED Desk Lamp',
                'description' => 'Adjustable LED desk lamp with touch controls and USB charging',
                'price' => 34.99,
                'moq' => 1,
                'unit' => 'piece',
                'origin_country' => 'China',
                'category_id' => $electronics ? $electronics->id : null,
                'subcategory_id' => null,
                'status' => 'active',
                'verification_status' => 'approved'
            ],
            [
                'name' => 'Cotton Bed Sheets Set',
                'description' => '4-piece queen size bed sheet set, 100% cotton',
                'price' => 59.99,
                'moq' => 1,
                'unit' => 'set',
                'origin_country' => 'Egypt',
                'category_id' => $homeGarden ? $homeGarden->id : null,
                'subcategory_id' => null,
                'status' => 'active',
                'verification_status' => 'approved'
            ],
            [
                'name' => 'Stainless Steel Water Bottle',
                'description' => 'Insulated water bottle keeps drinks cold for 24 hours',
                'price' => 24.99,
                'moq' => 10,
                'unit' => 'piece',
                'origin_country' => 'China',
                'category_id' => $sports ? $sports->id : null,
                'subcategory_id' => null,
                'status' => 'active',
                'verification_status' => 'approved'
            ],
            [
                'name' => 'Bluetooth Portable Speaker',
                'description' => 'Waterproof portable speaker with 360-degree sound',
                'price' => 59.99,
                'moq' => 1,
                'unit' => 'piece',
                'origin_country' => 'China',
                'category_id' => $electronics ? $electronics->id : null,
                'subcategory_id' => null,
                'status' => 'active',
                'verification_status' => 'approved'
            ],
            [
                'name' => 'Kitchen Knife Set',
                'description' => 'Professional 8-piece kitchen knife set with wooden block',
                'price' => 89.99,
                'moq' => 1,
                'unit' => 'set',
                'origin_country' => 'Germany',
                'category_id' => $homeGarden ? $homeGarden->id : null,
                'subcategory_id' => null,
                'status' => 'active',
                'verification_status' => 'approved'
            ]
        ];
        
        // Create products
        foreach ($products as $productData) {
            $product = new Product();
            $product->seller_id = $seller->id;
            $product->category_id = $productData['category_id'];
            $product->subcategory_id = $productData['subcategory_id'];
            $product->name = $productData['name'];
            $product->slug = Str::slug($productData['name']) . '-' . time() . rand(100, 999);
            $product->description = $productData['description'];
            $product->price = $productData['price'];
            $product->moq = $productData['moq'];
            $product->unit = $productData['unit'];
            $product->origin_country = $productData['origin_country'];
            $product->status = $productData['status'];
            $product->verification_status = $productData['verification_status'];
            $product->save();
        }
        
        echo "Created " . count($products) . " demo products for seller.\n";
    }
}