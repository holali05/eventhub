<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class WhatsappService
{
    /**
     * Envoie un message texte simple
     * 
     * @param string $to Le numéro au format international (ex: 229XXXXXXXX)
     * @param string $message Le contenu du message
     */
    public static function sendMessage($to, $message)
    {
        // Pour l'instant, on écrit dans les logs de Laravel (storage/logs/laravel.log)
        // Le Développeur 3 remplacera cela par l'appel API réel (Twilio, Evolution API, etc.)
        Log::info("WhatsApp Message envoyé à {$to} : {$message}");

        return true; 
    }

    /**
     * Envoie un message avec un fichier attaché (Le Ticket PDF/Image)
     * 
     * @param string $to Le numéro
     * @param string $message Le texte qui accompagne le fichier
     * @param string $fileUrl L'URL du ticket généré
     */
    public static function sendTicket($to, $message, $fileUrl)
    {
        Log::info("WhatsApp Ticket envoyé à {$to}. Fichier : {$fileUrl}. Message : {$message}");

        return true;
    }
}