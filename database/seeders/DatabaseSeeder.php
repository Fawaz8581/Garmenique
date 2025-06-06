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
            'name' => 'Admin',
            'email' => 'admin@garmenique.us',
            'password' => bcrypt('Garmenique2025'),
            'role' => 'admin',
        ]);

        // Seed categories
        $this->call(CategorySeeder::class);

        $this->call([
            SizeSeeder::class,
        ]);
    }
}
