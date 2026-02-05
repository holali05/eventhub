<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // On appelle nos seeders personnalisés
        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
        ]);
    }
}