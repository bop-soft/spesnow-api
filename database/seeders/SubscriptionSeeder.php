<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subscription;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subscription::create([
            'title' => 'bronze',
            'price' => 10000,
            'timeframe' => 'month'
        ]);
        Subscription::create([
            'title' => 'silver',
            'price' => 25000,
            'timeframe' => 'quarter'
        ]);
        Subscription::create([
            'title' => 'gold',
            'price' => 275000,
            'timeframe' => 'year'
        ]);
    }
}
