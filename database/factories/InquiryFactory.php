<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Inquiry;
use App\Models\Conversation;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inquiry>
 */
class InquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'conversation_id' => Conversation::factory(),
            'product_id' => Product::factory(),
            'notes' => $this->faker->optional()->sentence(),
            'added_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
