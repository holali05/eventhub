<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use App\Models\TicketType;
use App\Models\Ticket;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. On récupère l'organisateur "Jean" créé par le Dev 1
        $organizer = User::where('email', 'jean@eventhub.com')->first();

        if ($organizer) {
            // 2. Création d'un événement de test
            $event = Event::create([
                'user_id' => $organizer->id,
                'title' => 'Concert de Gala Scolaire',
                'description' => 'Un événement exceptionnel pour célébrer la fin d\'année avec tous les étudiants.',
                'location' => 'Amphithéâtre Principal',
                'event_date' => now()->addDays(30)->format('Y-m-d'),
                'event_time' => '19:00:00',
            ]);

            // 3. Création des types de tickets
            $vip = TicketType::create([
                'event_id' => $event->id,
                'name' => 'VIP',
                'price' => 10000.00,
                'total_quantity' => 50,
                'remaining_quantity' => 50,
            ]);

            $standard = TicketType::create([
                'event_id' => $event->id,
                'name' => 'Standard',
                'price' => 2000.00,
                'total_quantity' => 200,
                'remaining_quantity' => 200,
            ]);

            // 4. Création d'un ticket de test (déjà acheté) pour tes futurs designs
            Ticket::create([
                'ticket_type_id' => $vip->id,
                'customer_name' => 'Marc Dupont',
                'customer_whatsapp' => '22990000000',
                'customer_email' => 'marc@example.com',
                'unique_hash' => (string) Str::uuid() . '-TEST',
                'is_scanned' => false,
            ]);
        }
    }
}