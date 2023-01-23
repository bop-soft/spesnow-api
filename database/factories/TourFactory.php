<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TourFactory extends Factory
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
            'schedule' => fake()->dateTime($max = 'now', $timezone = 'Africa/Kampala'),
            'people' => fake()->numberBetween(1,5),
            'status' => fake()->randomElement(['pending','completed','cancelled'])
        ];
    }
}
