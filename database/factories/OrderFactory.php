<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "category_id" => null,
            "customer_name" => fake()->name(),
            "customer_address" => fake()->address(),
            "due_date" => now()->addDay()->toDateTimeString(),
            "payment_date" => null,
            "created_at" => now()->toDateTimeString(),
        ];
    }

    /**
     * Indicate that the model's payment_date should be present.
     */
    public function withPaymentDate(): static
    {
        return $this->state(fn (array $attributes) => [
            "payment_date" => now()->addMinutes(20)->toDateTimeString(),
        ]);
    }

    /**
     * Indicate that the model's category_id should be present.
     */
    public function withCategory(): static
    {
        $category = Category::factory()->create();

        return $this->state(fn (array $attributes) => [
            "category_id" => $category->id,
        ]);
    }
}
