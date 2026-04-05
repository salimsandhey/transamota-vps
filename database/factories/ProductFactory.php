<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'seller_id' => User::factory(),
            'category_id' => Category::factory(),
            'subcategory_id' => Subcategory::factory(),
            'name' => $this->faker->sentence(3),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'moq' => $this->faker->numberBetween(1, 100),
            'unit' => $this->faker->randomElement(['piece', 'set', 'kg', 'meter']),
            'origin_country' => $this->faker->country(),
            'status' => $this->faker->randomElement(['active', 'inactive', 'pending']),
            'verification_status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'is_featured' => $this->faker->boolean(),
        ];
    }
}
