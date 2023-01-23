<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RentalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->word(),
            'user_id' => fake()->numberBetween(1,10),
            'category_id' => fake()->numberBetween(1,5),
            'category' => fake()->randomElement(['apartment','muzigo','single unit','shop','warehouse']),
            'village_id' => fake()->numberBetween(1,20),
            'village' => fake()->randomElement(['kiwafu East','Kiwafu West','Kiwafu Central']),
            'parish' => fake()->randomElement(['Kiwafu','Katabi']),
            'subcounty' => fake()->randomElement(['division a','division b']),
            'district' => fake()->randomElement(['wakiso','kampala','mukono','busia','mbarara']),
            'price' => rand(100000,10000000),
            'bedrooms' => fake()->numberBetween(1,5),
            'bathrooms' => fake()->numberBetween(0,3),
            'kitchens' => fake()->numberBetween(0,2),
        ];
    }
}
