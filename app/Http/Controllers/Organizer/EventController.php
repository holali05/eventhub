<?php
namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller {
    
    
    public function index() {
        $events = Event::where('status', 'approved')->get();
        return view('welcome', compact('events'));
    }

    
    public function create() {
        return view('organizer.create');
    }

    
    public function store(Request $request) {
        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['status'] = 'pending'; 

        if($request->hasFile('ticket_template')) {
            $data['ticket_template'] = $request->file('ticket_template')->store('tickets', 'public');
        }

        Event::create($data);
        return redirect()->route('dashboard')->with('success', 'Événement créé ! En attente de validation.');
    }

    
    public function organizerDashboard() {
        $events = Event::where('user_id', auth()->id())->get();
        return view('organizer.dashboard', compact('events'));
    }

    
    public function adminIndex() {
        $pendingEvents = Event::where('status', 'pending')->get();
        return view('organizer.admin_moderation', compact('pendingEvents'));
    }

    
    public function approveEvent($id) {
        $event = Event::findOrFail($id);
        $event->update(['status' => 'approved']);
        return back()->with('success', 'L\'événement a été publié avec succès !');
    }

    
    public function destroy($id) {
        $event = Event::findOrFail($id);
        $event->delete();
        return back()->with('success', 'Événement supprimé.');
    }
}