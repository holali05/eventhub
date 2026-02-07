<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;

class AdminController extends Controller
{
   

    public function index()
    {
        
        $users = User::where('id', '!=', auth()->id())->latest()->get();
    
        
        $totalUsers = $users->count();
        $pendingCount = $users->where('status', 'pending')->count();
        $approvedCount = $users->where('status', 'approved')->count();

        return view('admin.users.index', compact('users', 'totalUsers', 'pendingCount', 'approvedCount'));
    }

    public function approve(User $user)
    {
       
        $user->update(['status' => 'approved']);

        return redirect()->route('admin.users.index')->with('success', "Le compte de {$user->name} est validé !");
    }

    // --- GESTION DES ÉVÉNEMENTS ---

    public function eventsIndex()
    {
        
        $events = Event::with('user')->latest()->get();

        return view('admin.events.index', compact('events'));
    }

    public function approveEvent(Event $event)
    {
        $event->update([
            'is_published' => true,
            'admin_status' => 'approved' 
        ]);

        return redirect()->back()->with('success', "L'événement '{$event->title}' a été approuvé !");
    }

    public function refuseEvent(Request $request, Event $event)
    {
        $request->validate([
            'reason' => 'required|string|min:5'
        ]);

        $event->update([
            'admin_status' => 'rejected',
            'rejection_reason' => $request->reason,
            'is_published' => false
        ]);

        return back()->with('success', "Événement refusé.");
    }
}