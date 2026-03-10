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

            // Top 5 événements par taux de remplissage
            $topEvents = Event::where('admin_status', 'approved')
                ->get()
                ->sortByDesc('fill_rate')
                ->take(5);

            // Données pour le graphique (12 mois)
            $chartData = [];
            for ($i = 11; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $chartData[] = Booking::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count();
            }

            $pendingEvents = Event::where('admin_status', 'pending')->with('user')->latest()->take(5)->get();

            return view('dashboard', compact('totalUsers', 'totalEvents', 'totalBookings', 'pendingEvents', 'topEvents', 'chartData'));
        }


        if ($user->role === 'organizer') {
            $myEventsCount = Event::where('user_id', $user->id)->count();

            // Calculer le revenu total pour l'organisateur
            $totalRevenue = Booking::whereHas('event', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->where('status', 'confirmé')->get()->sum(function ($booking) {
                return $booking->tickets_count * ($booking->ticketType->price ?? 0);
            });

            $myBookingsCount = Booking::whereHas('event', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->count();

            // Dernières activités (réservations récentes)
            $recentBookings = Booking::whereHas('event', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->with(['event', 'ticketType'])->latest()->take(5)->get();

            // Données pour le graphique (6 derniers mois)
            $chartData = [];
            for ($i = 5; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $count = Booking::whereHas('event', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count();
                $chartData[] = $count;
            }

            $events = Event::where('user_id', $user->id)->latest()->get();

            return view('dashboard', compact('myEventsCount', 'myBookingsCount', 'totalRevenue', 'recentBookings', 'chartData', 'events'));
        }


        $myTicketsCount = Booking::where('user_id', $user->id)->count();
        return view('dashboard', compact('myTicketsCount'));
    }
}