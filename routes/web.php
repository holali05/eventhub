<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ROUTES PUBLIQUES (Accessibles par tout le monde)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Page d'un événement et achat de ticket (Pour les Dev 4 et 5)
Route::post('/tickets/purchase', [TicketController::class, 'store'])->name('tickets.purchase');

/*
|--------------------------------------------------------------------------
| ROUTES PROTEGÉES (Connexion requise + Compte Approuvé)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'approved'])->group(function () {
    
    // Dashboard principal
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // --- Espace Organisateur (Pour le Dev 2) ---
    Route::prefix('organizer')->name('organizer.')->group(function () {
        // Routes pour la gestion des événements
        // Route::resource('events', EventController::class);
        
        // Route pour scanner/vérifier un ticket
        Route::get('/tickets/verify/{hash}', [TicketController::class, 'verify'])->name('tickets.verify');
    });

    // --- Espace Admin (Pour le Dev 2) ---
    // On ajoute une vérification supplémentaire pour s'assurer que c'est un admin
    Route::middleware(['can:admin-access'])->prefix('admin')->name('admin.')->group(function () {
        // Gestion des utilisateurs, validation des comptes, etc.
    });

    // Profil (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';