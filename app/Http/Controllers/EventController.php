<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\TicketType; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * Affiche les détails d'un événement (Public)
     */
    public function show($id)
    {
       
        $event = Event::with('ticketTypes')->findOrFail($id);
        return view('events.show', compact('event'));
    }

    /**
     * Liste des événements de l'organisateur
     */
    public function myEvents()
    {
        $myEvents = Event::where('user_id', auth()->id())
                         ->with('ticketTypes') 
                         ->latest()
                         ->get();

        return view('organizer.events.index', compact('myEvents'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        return view('organizer.events.create');
    }

    /**
     * Enregistrement de l'événement (CORRIGÉ POUR ÉVITER L'ERREUR 403)
     */
    public function store(Request $request)
    {
       
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string',
            'event_date' => 'required|date',
            'event_time' => 'required',
            'capacity' => 'required|integer|min:1',
            'image' => 'required|image|max:5000', 
            'ticket_template' => 'required|image|max:5000', 
            'tickets' => 'required|array|min:1',
            'tickets.*.name' => 'required|string|max:100',
            'tickets.*.price' => 'required|numeric|min:0',
            'tickets.*.total_quantity' => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($request) {
            
            
            $imagePath = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_cover_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/events/covers'), $filename);
                $imagePath = 'uploads/events/covers/' . $filename;
            }

            
            $ticketPath = null;
            if ($request->hasFile('ticket_template')) {
                $fileTicket = $request->file('ticket_template');
                $filenameTicket = time() . '_ticket_' . $fileTicket->getClientOriginalName();
                $fileTicket->move(public_path('uploads/events/tickets'), $filenameTicket);
                $ticketPath = 'uploads/events/tickets/' . $filenameTicket;
            }

            
            $event = Event::create([
                'user_id' => auth()->id(),
                'title' => $request->title,
                'description' => $request->description,
                'location' => $request->location,
                'event_date' => $request->event_date,
                'event_time' => $request->event_time,
                'capacity' => $request->capacity,
                'image_path' => $imagePath,
                'ticket_template_path' => $ticketPath,
                'admin_status' => 'pending', 
                'is_published' => false,
            ]);

            
            foreach ($request->tickets as $ticketData) {
                TicketType::create([
                    'event_id' => $event->id,
                    'name' => $ticketData['name'],
                    'price' => $ticketData['price'],
                    'total_quantity' => $ticketData['total_quantity'],
                    'remaining_quantity' => $ticketData['total_quantity'],
                ]);
            }

            return redirect()->route('organizer.events.index')
                             ->with('success', 'Événement créé avec succès !');
        });
    }

    /**
     * Suppression de l'événement et de ses fichiers physiques
     */
    public function destroy(Event $event)
    {
        
        if ($event->image_path && file_exists(public_path($event->image_path))) {
            unlink(public_path($event->image_path));
        }

        
        if ($event->ticket_template_path && file_exists(public_path($event->ticket_template_path))) {
            unlink(public_path($event->ticket_template_path));
        }

        $event->delete();

        return redirect()->route('organizer.events.index')
                         ->with('success', 'Événement et fichiers supprimés.');
    }
}