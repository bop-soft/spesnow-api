<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Advert;

class AdvertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Advert::create([
            'title' => 'basic',
            'price' => 30000,
            'timeframe' => 'week'
        ]);
        Advert::create([
            'title' => 'standard',
            'price' => 90000,
            'timeframe' => 'month'
        ]);
        Advert::create([
            'title' => 'premium',
            'price' => 240000,
            'timeframe' => 'quarter'
        ]);
    }
}
