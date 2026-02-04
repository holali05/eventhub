<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Organizer\EventController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;


Route::get('/', [EventController::class, 'index'])->name('welcome');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth'])->group(function () {
    Route::get('/organizer/dashboard', [EventController::class, 'organizerDashboard'])->name('organizer.dashboard');
    Route::get('/organizer/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/organizer/events', [EventController::class, 'store'])->name('events.store');
    Route::delete('/organizer/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/admin/moderation', [EventController::class, 'adminIndex'])->name('admin.moderation');
    
    Route::post('/admin/approve-event/{id}', [EventController::class, 'approveEvent'])->name('admin.approve-event');
    
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/approve-user/{id}', [AdminController::class, 'approveUser'])->name('admin.approve-user');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';