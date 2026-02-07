<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

       
        if ($user->role === 'admin') {
            $totalUsers = User::count();
            $totalEvents = Event::count();
            $totalBookings = Booking::count();
            
            
            $pendingEvents = Event::where('admin_status', 'pending')->latest()->take(5)->get();

            return view('dashboard', compact('totalUsers', 'totalEvents', 'totalBookings', 'pendingEvents'));
        }

        
        if ($user->role === 'organizer') {
            $myEventsCount = Event::where('user_id', $user->id)->count();
            $myBookingsCount = Booking::whereHas('event', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })->count();

            
            $events = Event::where('user_id', $user->id)->latest()->get();

            return view('dashboard', compact('myEventsCount', 'myBookingsCount', 'events'));
        }

        
        $myTicketsCount = Booking::where('user_id', $user->id)->count();
        return view('dashboard', compact('myTicketsCount'));
    }
}