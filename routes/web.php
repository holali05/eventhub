<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\WhatsappListController;
use App\Models\Event;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $events = Event::with('tickets') 
                ->where('admin_status', 'approved')
                ->latest()
                ->get();
    return view('welcome', compact('events'));
})->name('home');

Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');

// --- ROUTES DE BILLETTERIE (Mission Dev 4) ---
Route::post('/tickets/purchase', [TicketController::class, 'store'])->name('tickets.purchase');
// Route pour visualiser/télécharger le ticket PDF
Route::get('/tickets/download/{hash}', [TicketController::class, 'download'])->name('tickets.download');

Route::middleware(['auth'])->group(function () {

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [AdminController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}/approve', [AdminController::class, 'approve'])->name('users.approve');

        Route::get('/events', [AdminController::class, 'eventsIndex'])->name('events.index');
        Route::patch('/events/{event}/approve', [AdminController::class, 'approveEvent'])->name('events.approve');
        Route::patch('/events/{event}/refuse', [AdminController::class, 'refuseEvent'])->name('events.refuse');
    });
    
    Route::middleware(['approved'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
        Route::get('/my-bookings', [BookingController::class, 'index'])->name('bookings.index');

        Route::prefix('organizer')->name('organizer.')->group(function () {
            Route::get('/my-events', [EventController::class, 'myEvents'])->name('events.index');
            Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
            Route::post('/events', [EventController::class, 'store'])->name('events.store');
            Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
            Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
            
            Route::get('/tickets/verify/{hash}', [TicketController::class, 'verify'])->name('tickets.verify');
            Route::get('/events/{event}/participants', [BookingController::class, 'participants'])->name('events.participants');
        });
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route pour l'importation CSV
Route::post('/import-whatsapp', [WhatsappListController::class, 'import'])->name('whatsapp.import');

require __DIR__.'/auth.php';