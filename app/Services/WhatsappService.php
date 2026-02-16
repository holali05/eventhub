<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class WhatsappService
{
    /**
     * Récupère la configuration de l'API
     */
    protected static function getConfig()
    {
        return [
            'url'      => config('services.whatsapp.url'),
            'instance' => config('services.whatsapp.instance'),
            'token'    => config('services.whatsapp.token'),
        ];
    }

 public static function sendMessage($to, $message)
{
    $config = [
        'url' => config('services.whatsapp.url'),
        'instance' => config('services.whatsapp.instance'),
        'token' => config('services.whatsapp.token'),
    ];

    $to = preg_replace('/[^0-9]/', '', $to);

    try {
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'apikey' => $config['token'],
            'Content-Type' => 'application/json'
        ])->post("{$config['url']}/message/sendText/{$config['instance']}", [
            'number' => $to,
            'text' => $message 
        ]);

       if ($response->successful()) {
            // AJOUTE CETTE LIGNE :
            \Illuminate\Support\Facades\Log::info("RÉPONSE API WHATSAPP : " . $response->body());
            return true;
        }

        \Illuminate\Support\Facades\Log::error("WhatsApp API Error: " . $response->body());
        return false;
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error("WhatsApp Service Exception: " . $e->getMessage());
        return false;
    }
}

}