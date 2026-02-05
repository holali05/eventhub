<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    /**
     * Logique d'achat d'un billet
     */
    public function store(Request $request)
    {
        // 1. Validation des données du client
        $request->validate([
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'customer_name' => 'required|string|max:255',
            'customer_whatsapp' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
        ]);

        try {
            // 2. Utilisation d'une transaction pour garantir que tout se passe bien
            $ticket = DB::transaction(function () use ($request) {
                
                // 3. On récupère le type de ticket avec un "Verrou" (lockForUpdate)
                // Cela empêche une autre requête de modifier ce stock en même temps
                $ticketType = TicketType::where('id', $request->ticket_type_id)
                    ->lockForUpdate()
                    ->first();

                // 4. Vérification de la disponibilité
                if ($ticketType->remaining_quantity <= 0) {
                    throw new \Exception("Désolé, il n'y a plus de places disponibles pour cette catégorie.");
                }

                // 5. Création du hash unique pour le QR Code (Inviolable)
                // On utilise un UUID + une chaîne aléatoire pour être ultra sécurisé
                $uniqueHash = Str::uuid() . '-' . Str::random(10);

                // 6. Création du ticket
                $newTicket = Ticket::create([
                    'ticket_type_id' => $ticketType->id,
                    'customer_name' => $request->customer_name,
                    'customer_whatsapp' => $request->customer_whatsapp,
                    'customer_email' => $request->customer_email,
                    'unique_hash' => $uniqueHash,
                ]);

                // 7. Mise à jour du stock
                $ticketType->decrement('remaining_quantity');

                return $newTicket;
            });

            // 8. Retour vers la vue de succès (Le Dev 4 et 5 s'occuperont de l'affichage)
            return back()->with('success', 'Votre ticket a été réservé avec succès !');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Vérification du QR Code (Scannage à l'entrée)
     */
    public function verify($hash)
    {
        // 1. On cherche le ticket par son hash
        $ticket = Ticket::where('unique_hash', $hash)->first();

        if (!$ticket) {
            return response()->json(['status' => 'error', 'message' => 'Ticket invalide ou inexistant.'], 404);
        }

        // 2. Vérification si déjà scanné
        if ($ticket->is_scanned) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Attention ! Ce ticket a déjà été utilisé le ' . $ticket->scanned_at->format('d/m/Y à H:i'),
                'customer' => $ticket->customer_name
            ]);
        }

        // 3. Validation du ticket
        $ticket->update([
            'is_scanned' => true,
            'scanned_at' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Ticket valide. Bienvenue !',
            'customer' => $ticket->customer_name,
            'type' => $ticket->ticketType->name
        ]);
    }
}