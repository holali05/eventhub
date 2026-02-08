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
        
        $request->validate([
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'customer_name' => 'required|string|max:255',
            'customer_whatsapp' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
        ]);

        try {
            
            $ticket = DB::transaction(function () use ($request) {
                
                
                $ticketType = TicketType::where('id', $request->ticket_type_id)
                    ->lockForUpdate()
                    ->first();

               
                if ($ticketType->remaining_quantity <= 0) {
                    throw new \Exception("Désolé, il n'y a plus de places disponibles pour cette catégorie.");
                }

                
                $uniqueHash = Str::uuid() . '-' . Str::random(10);

                
                $newTicket = Ticket::create([
                    'ticket_type_id' => $ticketType->id,
                    'customer_name' => $request->customer_name,
                    'customer_whatsapp' => $request->customer_whatsapp,
                    'customer_email' => $request->customer_email,
                    'unique_hash' => $uniqueHash,
                ]);

               
                $ticketType->decrement('remaining_quantity');

                return $newTicket;
            });

            
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
        
        $ticket = Ticket::where('unique_hash', $hash)->first();

        if (!$ticket) {
            return response()->json(['status' => 'error', 'message' => 'Ticket invalide ou inexistant.'], 404);
        }

       
        if ($ticket->is_scanned) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Attention ! Ce ticket a déjà été utilisé le ' . $ticket->scanned_at->format('d/m/Y à H:i'),
                'customer' => $ticket->customer_name
            ]);
        }

       
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