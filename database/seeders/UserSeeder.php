<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Un compte organisateur DÉJÀ APPROUVÉ
        User::create([
            'name' => 'Jean Organisateur',
            'email' => 'jean@eventhub.com',
            'password' => Hash::make('password'),
            'role' => 'organizer',
            'status' => 'approved', // Déjà validé
        ]);

        // 2. Un premier compte en ATTENTE d'approbation
        User::create([
            'name' => 'Alice en Attente',
            'email' => 'alice@eventhub.com',
            'password' => Hash::make('password'),
            'role' => 'organizer',
            'status' => 'pending', // En attente
        ]);

        // 3. Un deuxième compte en ATTENTE d'approbation
        User::create([
            'name' => 'Bob le Nouveau',
            'email' => 'bob@eventhub.com',
            'password' => Hash::make('password'),
            'role' => 'organizer',
            'status' => 'pending', // En attente
        ]);
    }
}