<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdvertSeeder::class);
        $this->call(SubscriptionSeeder::class);
        $this->call(UserSeeder::class);
        \App\Models\User::factory(7)->create();
        $this->call(CategorySeeder::class);
        $this->call(CountrySeeder::class);
        \App\Models\District::factory(5)->create();
        \App\Models\Subcounty::factory(10)->create();
        \App\Models\Parish::factory(15)->create();
        \App\Models\Village::factory(20)->create();
        \App\Models\Rental::factory(10)->create();
        \App\Models\Image::factory(10)->create();
        \App\Models\Amenity::factory(10)->create();
        \App\Models\Favorite::factory(5)->create();
        \App\Models\Unlock::factory(5)->create();
        \App\Models\Transaction::factory(10)->create();
        \App\Models\Tour::factory(5)->create();
        \App\Models\Rating::factory(5)->create();
    }
}
