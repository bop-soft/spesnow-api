<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Apartment',
            'image_url' => fake()->imageUrl, 
        ]);
        Category::create([
            'name' => 'Muzigo',
            'image_url' => fake()->imageUrl, 
        ]);
        Category::create([
            'name' => 'Single Unit',
            'image_url' => fake()->imageUrl, 
        ]);
        Category::create([
            'name' => 'Shop',
            'image_url' => fake()->imageUrl, 
        ]);
        Category::create([
            'name' => 'Warehouse',
            'image_url' => fake()->imageUrl, 
        ]);
    }
}
