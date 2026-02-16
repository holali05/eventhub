<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule; // Importation ajoutée

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Planification de la relance WhatsApp (J5-J6)
// On l'exécute tous les jours à 09:00 du matin
Schedule::command('reminders:send')->dailyAt('09:00');

// Note : Pour tes tests locaux, tu peux aussi utiliser ->everyMinute() 
// pour voir si cela se déclenche bien.