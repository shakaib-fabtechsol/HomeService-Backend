<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Customer',
            'email' => 'customer@gmail.com',
            'role' => 1,
            'phone' => '123456789',
            'terms' => 1,
            'password' => 'aszx1234',
        ]);

        User::factory()->create([
            'name' => 'Service Provider',
            'email' => 'serviceprovider@gmail.com',
            'role' => 2,
            'phone' => '123456789',
            'terms' => 1,
            'password' => 'aszx1234',
        ]);
    }
}
