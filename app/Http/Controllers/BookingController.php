<?php

namespace App\Http\Controllers;

use App\Mail\BookingMail;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class BookingController extends Controller
{

    public function index()
    {
        $bookings = Booking::where('user_email', Auth::user()->email)
            ->with('event', 'ticketType')
            ->latest()
            ->get();

        return view('bookings.index', compact('bookings'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email',
            'tickets_count' => 'required|integer|min:1|max:10',
        ]);

        $ticketType = \App\Models\TicketType::with('event')->findOrFail($request->ticket_type_id);

        if ($ticketType->remaining_quantity < $request->tickets_count) {
            return redirect()->back()->with('error', "Désolé, il n'y a plus assez de places disponibles pour ce type de ticket.");
        }

        $uniqueHash = Str::uuid()->toString();

        return \Illuminate\Support\Facades\DB::transaction(function () use ($request, $ticketType, $uniqueHash) {

            $booking = Booking::create([
                'event_id' => $request->event_id,
                'ticket_type_id' => $request->ticket_type_id,
                'user_name' => $request->user_name,
                'user_email' => $request->user_email,
                'tickets_count' => $request->tickets_count,
                'status' => 'confirmé',
                'unique_hash' => $uniqueHash,
            ]);

            $ticketType->decrement('remaining_quantity', $request->tickets_count);

            // Charger les relations pour l'email
            $booking->load('event', 'ticketType');

            // Envoi de l'email de confirmation
            try {
                Mail::to($booking->user_email)->send(new BookingMail($booking));
            } catch (\Exception $e) {
                // L'email échoue silencieusement pour ne pas bloquer la réservation
                \Illuminate\Support\Facades\Log::warning('Booking confirmation email failed: ' . $e->getMessage());
            }

            return redirect()->back()->with('success', '🎉 Réservation confirmée ! Un email de confirmation vous a été envoyé.');
        });
    }

    public function participants(Event $event)
    {
        $bookings = $event->bookings()->with('ticketType')->latest()->get();

        return view('organizer.events.participants', compact('event', 'bookings'));
    }
}