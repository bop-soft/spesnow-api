<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => fake()->numberBetween(1,3),
            'rental_id' => fake()->numberBetween(1,5),
            'type' => fake()->randomElement(['deposit','utility','unlock','refund','subscription']),
            'amount' => fake()->numberBetween(10000,240000),
            'status' => fake()->randomElement(['pending','successful','failed','cancelled'])
        ];
    }
}
