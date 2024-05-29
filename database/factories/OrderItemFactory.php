<?php

namespace Database\Factories;

use App\Enums\VatRate;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vatRates = VatRate::values();
        return [
            "name" => fake()->lastName(),
            "count" => fake()->numberBetween(1, 25),
            "cost" => fake()->randomFloat(2, 19.99, 999.99),
            "vat" => $vatRates[array_rand($vatRates)],
        ];
    }
}
