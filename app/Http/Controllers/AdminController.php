<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Page : Liste des utilisateurs à approuver
     */
    public function index()
    {
       
        $users = User::where('role', '!=', 'admin')
                     ->where('is_approved', false)
                     ->latest()
                     ->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Page : Liste de TOUS les événements pour modération (Celle qui causait l'erreur)
     */
    public function eventsIndex()
    {
        
        $events = Event::with('user')->latest()->get();
        
        return view('admin.events.index', compact('events'));
    }

    /**
     * Action : Confirmer (Approuver) un compte utilisateur
     */
    public function approve(User $user)
    {
        $user->update(['is_approved' => true]);
        return redirect()->back()->with('success', "Le compte de {$user->name} a été confirmé.");
    }

    /**
     * Action : Approuver un événement
     */
    public function approveEvent(Event $event)
    {
        $event->update([
            'admin_status' => 'approved',
            'is_published' => true
        ]);
        return redirect()->back()->with('success', "L'événement a été approuvé et publié.");
    }

    /**
     * Action : Refuser un événement
     */
    public function refuseEvent(Request $request, Event $event)
    {
        $request->validate(['reason' => 'required|string|min:5']);

        $event->update([
            'admin_status' => 'refused',
            'is_published' => false,
            'rejection_reason' => $request->reason
        ]);
        return redirect()->back()->with('success', "L'événement a été refusé.");
    }
}