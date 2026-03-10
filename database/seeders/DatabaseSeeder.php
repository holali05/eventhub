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
    \App\Models\User::create([
        'name' => 'Admin System',
        'email' => 'admin@eventhub.com',
        'password' => bcrypt('password'), // Le mot de passe sera 'password'
        'role' => 'admin',
        'is_approved' => true,
    ]);
}
}