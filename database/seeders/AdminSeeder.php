<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrateur EventHub',
            'email' => 'admin@eventhub.com',
            'password' => Hash::make('password'), // Changez ce mot de passe plus tard
            'role' => 'admin',
            'status' => 'approved',
        ]);
    }
}