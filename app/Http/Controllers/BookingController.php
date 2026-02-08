<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    
    public function index()
    {
        
        $bookings = Booking::where('user_email', Auth::user()->email)
            ->with('event')
            ->latest()
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email',
            'tickets_count' => 'required|integer|min:1|max:10',
        ]);

        $ticketNumber = 'TICKET-' . strtoupper(Str::random(5)) . '-' . date('Y');

        
        $booking = Booking::create([
            'event_id' => $request->event_id,
            'user_name' => $request->user_name,
            'user_email' => $request->user_email,
            'tickets_count' => $request->tickets_count,
            'status' => 'confirmé',
            
        ]);

        return redirect()->back()->with('success', "Félicitations ! Réservation confirmée. Votre numéro de ticket temporaire est : $ticketNumber");
    }
}