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
        // On appelle nos seeders personnalisés dans le bon ordre
        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
            EventSeeder::class, // <--- AJOUTEZ CETTE LIGNE
        ]);
    }
}