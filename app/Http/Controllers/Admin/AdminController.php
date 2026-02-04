<?php

namespace App\Http\Controllers\Admin; 

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    
    public function index() {
        
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Accès réservé à l\'admin.');
        }

        $pendingEvents = Event::where('status', 'pending')->latest()->get();
        $pendingUsers = User::where('is_approved', false)->where('role', '!=', 'admin')->get();

        
        $events = Event::withCount('tickets')
                    ->with(['ticketTypes'])
                    ->get()
                    ->map(function($event) {
                        $totalCapacity = $event->ticketTypes->sum('capacity');
                        $event->fill_rate = $totalCapacity > 0 ? ($event->tickets_count / $totalCapacity) * 100 : 0;
                        return $event;
                    });

        return view('admin.dashboard', compact('pendingEvents', 'pendingUsers', 'events'));
    }

    
    public function approveUser($id) {
        $user = User::findOrFail($id);
        $user->update(['is_approved' => true]);
        return back()->with('success', "Le compte de {$user->name} est validé !");
    }

    
    public function approveEvent($id) {
        $event = Event::findOrFail($id);
        $event->update(['status' => 'approved']);
        return back()->with('success', 'L\'événement est maintenant public !');
    }

    
    public function destroyUser($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'Utilisateur supprimé.');
    }
}