<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'superadmin'
        ]);

        $this->call([
            CategorySeeder::class,
            CurrencySeeder::class,
            ProductSeeder::class,
            VariantSeeder::class,
            CouponSeeder::class,
            StateSeeder::class,
            CitySeeder::class,
        ]);
    }
}
