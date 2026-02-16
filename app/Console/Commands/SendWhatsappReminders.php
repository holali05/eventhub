<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WhatsappList;
use App\Jobs\SendWhatsappJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class SendWhatsappReminders extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Envoie les relances WhatsApp intelligentes J-7, J-4, J-3, J-1 et Jour J';

    public function handle()
    {
        $this->info("Analyse des rappels à envoyer...");

        // On récupère tous les contacts actifs avec leurs événements
        $contacts = WhatsappList::where('is_active', true)
            ->with('event')
            ->get();

        if ($contacts->isEmpty()) {
            $this->comment("Aucun contact trouvé en base de données.");
            return;
        }

        foreach ($contacts as $contact) {
            if (!$contact->event) continue;
            
            $eventDateRaw = $contact->event->date 
                         ?? $contact->event->start_date 
                         ?? $contact->event->event_date 
                         ?? $contact->event->date_debut;

            if (!$eventDateRaw) {
                $this->error("Impossible de trouver la date pour l'événement : {$contact->event->title}");
                continue;
            }

            // Calcul précis de la différence de jours
            $eventDate = Carbon::parse($eventDateRaw)->startOfDay();
            $today = now()->startOfDay();
            $daysRemaining = (int)$today->diffInDays($eventDate, false);

            $this->line("Vérification : Event '{$contact->event->title}' (Date: {$eventDate->format('d-m-Y')}) -> J-{$daysRemaining}");

            // Définition du contenu selon les jours restants
            $reminderContent = match($daysRemaining) {
                7 => "📅 J-7 : Plus qu'une semaine avant *{$contact->event->title}* ! ✨",
                4 => "🚨 J-4 : L'événement *{$contact->event->title}* approche à grands pas (dans 4 jours) ! Préparez-vous ! 🎊",
                3 => "🔥 J-3 : Le compte à rebours est lancé pour *{$contact->event->title}* ! 😉",
                1 => "📢 J-1 : C'est DEMAIN ! Votre place pour *{$contact->event->title}* vous attend. 🎟️",
                0 => "🚀 JOUR J : C'est aujourd'hui ! On se voit tout à l'heure à *{$contact->event->title}* ! 🎉",
                default => null
            };

            if ($reminderContent) {
                // Vérification pour ne pas envoyer deux fois le même rappel le même jour
                if (!$contact->last_sent_at || !$contact->last_sent_at->isToday()) {
                    
                    // ENVOI DU JOB
                    SendWhatsappJob::dispatch($contact->phone_number, $reminderContent);
                    
                    // Mise à jour du statut d'envoi
                    $contact->update(['last_sent_at' => now()]);
                    
                    $this->info("   => Rappel J-{$daysRemaining} mis en file d'attente pour {$contact->phone_number}");
                } else {
                    $this->comment("   => Déjà relancé aujourd'hui.");
                }
            }
        }

        $this->info("Traitement terminé.");
    }
}