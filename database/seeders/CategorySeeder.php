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
            'name' => 'apartment',
            'image_url' => fake()->imageUrl, 
        ]);
        Category::create([
            'name' => 'muzigo',
            'image_url' => fake()->imageUrl, 
        ]);
        Category::create([
            'name' => 'single unit',
            'image_url' => fake()->imageUrl, 
        ]);
        Category::create([
            'name' => 'shop',
            'image_url' => fake()->imageUrl, 
        ]);
        Category::create([
            'name' => 'warehouse',
            'image_url' => fake()->imageUrl, 
        ]);
    }
}
