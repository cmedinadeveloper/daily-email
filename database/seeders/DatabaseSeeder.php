<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Carlos One',
            'email' => 'carlos.one@example.com',
            'password' => bcrypt('password'),
            'timezone' => 'America/New_York', // Add this line
        ]);

        User::create([
            'name' => 'Carlos Two',
            'email' => 'carlos.two@example.com',
            'password' => bcrypt('password'),
            'timezone' => 'Europe/London', // Add this line
        ]);

        // Optionally, use the factory to create more users
        User::factory(10)->create();
    }
}
