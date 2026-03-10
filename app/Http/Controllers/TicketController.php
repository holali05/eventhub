<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\WhatsappList;
use App\Services\WhatsappService;
use App\Jobs\SendWhatsappJob;
use App\Mail\TicketMail; // AJOUTÉ POUR LE DEV 4
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail; // AJOUTÉ POUR LE DEV 4
// AJOUTS POUR LE DEV 4
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
            $data = DB::transaction(function () use ($request) {

                $ticketType = TicketType::with('event')->where('id', $request->ticket_type_id)
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

                WhatsappList::updateOrCreate(
                    [
                        'phone_number' => $request->customer_whatsapp,
                        'event_id' => $ticketType->event_id
                    ],
                    [
                        'contact_name' => $request->customer_name,
                        'frequency' => 'daily',
                        'is_active' => true
                    ]
                );

                $ticketType->decrement('remaining_quantity');

                return [
                    'ticket' => $newTicket,
                    'event_title' => $ticketType->event->title ?? 'l’événement'
                ];
            });

            // 1. ENVOI DU MESSAGE WHATSAPP (Mission Dev 3)
            $message = "Félicitations *{$data['ticket']->customer_name}* ! 🎉\n\n" .
                "Votre billet pour *{$data['event_title']}* a été réservé avec succès.\n" .
                "Vous recevrez prochainement votre ticket QR Code sur ce numéro.\n\n" .
                "Merci de votre confiance !";

            SendWhatsappJob::dispatch($data['ticket']->customer_whatsapp, $message);

            // 2. ENVOI DE L'EMAIL AVEC LE TICKET PDF (Mission Dev 4)
            Mail::to($data['ticket']->customer_email)->send(new TicketMail($data['ticket']));

            return back()->with('success', 'Votre ticket a été réservé ! Une confirmation WhatsApp et votre ticket par mail vous ont été envoyés.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * GÉNÉRATION DU PDF (Mission Dev 4)
     * Cette méthode permet de visualiser ou télécharger le ticket
     */
    public function download($hash)
    {
        // 1. Chercher dans la table Tickets (achat invité)
        $data = \App\Models\Ticket::with('ticketType.event')->where('unique_hash', $hash)->first();

        // 2. Si non trouvé, chercher dans la table Bookings (réservation utilisateur)
        if (!$data) {
            $booking = \App\Models\Booking::with('ticketType.event')->where('unique_hash', $hash)->firstOrFail();

            // Mapper les champs de Booking vers une structure compatible avec la vue ticket
            $data = (object) [
                'customer_name' => $booking->user_name,
                'customer_email' => $booking->user_email,
                'unique_hash' => $booking->unique_hash,
                'ticketType' => $booking->ticketType,
            ];
        }

        // Utiliser $data (qui peut être un Model Ticket ou un objet mappé)
        $pdf = Pdf::loadView('ticket', ['ticket' => $data]);

        return $pdf->download('MonTicket-' . substr($hash, 0, 8) . '.pdf');
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
                'message' => 'Attention ! Ce ticket a déjà été utilisé.',
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
            'customer' => $ticket->customer_name
        ]);
    }
}