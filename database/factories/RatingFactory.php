<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RatingFactory extends Factory
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
            'title' => fake()->sentence($nbWords = 6, $variableNbWords = true),
            'desc' => fake()->paragraph($nbSentences = 3, $variableNbSentences = true),
            'rating' => fake()->numberBetween(1,5),
            'status' => fake()->randomElement(['moderation','active','declined'])
        ];
    }
}
