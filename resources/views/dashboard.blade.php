<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-slate-800 leading-tight tracking-tighter">
                {{ __('Tableau de bord') }}
            </h2>
            <span
                class="px-4 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold uppercase tracking-widest">
                Session : {{ ucfirst(Auth::user()->role) }}
            </span>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(Auth::user()->role === 'admin')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
                    <div class="bg-white/80 backdrop-blur-sm p-8 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-white/60 flex items-center justify-between hover:scale-[1.03] transition-transform animate-fade-up delay-100">
                        <div>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Utilisateurs</p>
                            <h3 class="text-4xl font-black text-slate-900">{{ $totalUsers }}</h3>
                        </div>
                        <div class="w-14 h-14 bg-coral-50 rounded-2xl flex items-center justify-center text-coral-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                    </div>

                    <div class="bg-white/80 backdrop-blur-sm p-8 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-white/60 flex items-center justify-between hover:scale-[1.03] transition-transform animate-fade-up delay-200">
                        <div>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Événements</p>
                            <h3 class="text-4xl font-black text-slate-900">{{ $totalEvents }}</h3>
                        </div>
                        <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    </div>

                    <div class="bg-white/80 backdrop-blur-sm p-8 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-white/60 flex items-center justify-between hover:scale-[1.03] transition-transform animate-fade-up delay-300">
                        <div>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Tickets Vendus</p>
                            <h3 class="text-4xl font-black text-slate-900">{{ $totalBookings }}</h3>
                        </div>
                        <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white/80 backdrop-blur-sm p-8 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-white/60 mb-10 animate-fade-up delay-200">
                    <h3 class="font-black text-xl text-slate-800 mb-6 flex items-center gap-2">
                        <span class="w-2 h-6 bg-coral-600 rounded-full"></span>
                        Analyse des réservations
                    </h3>
                    <canvas id="salesChart" height="80"></canvas>
                </div>

                <div class="bg-white/80 backdrop-blur-sm p-8 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-white/60 mb-10 animate-fade-up delay-300">
                    <h3 class="font-black text-xl text-slate-800 mb-6 flex items-center gap-2">
                        <span class="w-2 h-6 bg-orange-500 rounded-full"></span>
                        Taux de remplissage (Top Événements)
                    </h3>
                    <div class="space-y-6">
                        @forelse($topEvents ?? [] as $event)
                            <div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-sm font-bold text-slate-700">{{ $event->title }}</span>
                                    <span class="text-sm font-black text-coral-600">{{ $event->fill_rate }}%</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-3">
                                    <div class="bg-coral-600 h-3 rounded-full shadow-md"
                                        style="width: {{ $event->fill_rate }}%"></div>
                                </div>
                                <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-widest font-bold">
                                    {{ $event->bookings_count }} / {{ $event->total_capacity }} places vendues
                                </p>
                            </div>
                        @empty
                            <p class="text-slate-400 italic text-center">Aucune donnée de vente disponible.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white/80 backdrop-blur-sm rounded-[2rem] shadow-xl shadow-slate-200/50 border border-white/60 overflow-hidden mb-10 animate-fade-up delay-400">
                    <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                        <h3 class="font-black text-xl text-slate-800">Dernières demandes d'approbation</h3>
                        <a href="{{ route('admin.events.index') }}"
                            class="text-coral-600 font-bold text-sm hover:underline">Voir tout</a>
                    </div>
                    <div class="p-0">
                        @forelse($pendingEvents as $event)
                            <div
                                class="p-6 border-b border-slate-50 flex items-center justify-between hover:bg-slate-50 transition">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden">
                                        <img src="{{ asset($event->image_path) }}" class="w-full h-full object-cover"
                                            onerror="this.src='https://placehold.co/100x100'">
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $event->title }}</p>
                                        <p class="text-xs text-slate-400 italic">Par {{ $event->user->name ?? 'Inconnu' }}</p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <form action="{{ route('admin.events.approve', $event) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button
                                            class="px-4 py-2 bg-emerald-500 text-white rounded-xl text-xs font-black shadow-lg shadow-emerald-100 hover:bg-emerald-600">Approuver</button>
                                    </form>
                                    <form action="{{ route('admin.events.refuse', $event) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button
                                            class="px-4 py-2 bg-red-500 text-white rounded-xl text-xs font-black shadow-lg shadow-red-100 hover:bg-red-600">Refuser</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="p-10 text-center text-slate-400 italic">Tout est à jour !</div>
                        @endforelse
                    </div>
                </div>
            @endif

            @if(Auth::user()->role === 'organizer')
                <div class="mb-12">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                        <div>
                            <h3 class="text-4xl font-extrabold text-slate-900 font-outfit tracking-tighter">Hello, <span
                                    class="text-coral-600">{{ Auth::user()->name }}</span></h3>
                            <p class="text-slate-500 font-medium mt-1">Voici un aperçu de vos performances actuelles.</p>
                        </div>
                        <a href="{{ route('organizer.events.create') }}"
                            class="inline-flex items-center gap-3 px-8 py-4 bg-slate-950 text-white rounded-2xl font-black text-xs hover:bg-coral-600 transition shadow-2xl shadow-slate-200 transform active:scale-95 group uppercase tracking-widest leading-none">
                            <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            Créer un Événement
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                        <div class="bg-white/80 backdrop-blur-sm p-8 rounded-[2.5rem] border border-white/60 shadow-soft relative overflow-hidden group hover:scale-[1.03] transition-transform animate-fade-up delay-100">
                            <div
                                class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-coral-50 rounded-full blur-3xl opacity-50 group-hover:scale-150 transition-transform duration-700">
                            </div>
                            <div class="relative z-10 flex items-center gap-6">
                                <div
                                    class="w-16 h-16 bg-coral-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-coral-200">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] mb-1">Revenu
                                        Total</p>
                                    <h4 class="text-2xl font-black text-slate-900 font-outfit">
                                        {{ number_format($totalRevenue, 0, ',', ' ') }} <span
                                            class="text-xs text-slate-400">CFA</span></h4>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white/80 backdrop-blur-sm p-8 rounded-[2.5rem] border border-white/60 shadow-soft relative overflow-hidden group hover:scale-[1.03] transition-transform animate-fade-up delay-200">
                            <div
                                class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-emerald-50 rounded-full blur-3xl opacity-50 group-hover:scale-150 transition-transform duration-700">
                            </div>
                            <div class="relative z-10 flex items-center gap-6">
                                <div
                                    class="w-16 h-16 bg-emerald-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] mb-1">
                                        Réservations</p>
                                    <h4 class="text-2xl font-black text-slate-900 font-outfit">{{ $myBookingsCount }} <span
                                            class="text-xs text-slate-400">Tickets</span></h4>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white/80 backdrop-blur-sm p-8 rounded-[2.5rem] border border-white/60 shadow-soft relative overflow-hidden group hover:scale-[1.03] transition-transform animate-fade-up delay-300">
                            <div
                                class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-amber-50 rounded-full blur-3xl opacity-50 group-hover:scale-150 transition-transform duration-700">
                            </div>
                            <div class="relative z-10 flex items-center gap-6">
                                <div
                                    class="w-16 h-16 bg-amber-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-amber-200">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] mb-1">Mes
                                        Événements</p>
                                    <h4 class="text-2xl font-black text-slate-900 font-outfit">{{ $myEventsCount }} <span
                                            class="text-xs text-slate-400">Actifs</span></h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                        <!-- Chart section -->
                        <div class="lg:col-span-8 bg-white p-10 rounded-[3rem] shadow-soft border border-white/40">
                            <div class="flex items-center justify-between mb-10">
                                <h3 class="text-xl font-extrabold text-slate-900 font-outfit tracking-tight">Tendances
                                    Mobiles</h3>
                                <div
                                    class="px-4 py-1.5 bg-slate-50 border border-slate-100 rounded-xl text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    6 derniers mois</div>
                            </div>
                            <div class="h-80">
                                <canvas id="organizerChart"></canvas>
                            </div>
                        </div>

                        <!-- Recent activity Glassmorphism -->
                        <div class="lg:col-span-4 space-y-8">
                            <div class="bg-slate-900 rounded-[3rem] p-8 text-white relative overflow-hidden group">
                                <div
                                    class="absolute top-0 right-0 p-8 opacity-10 group-hover:scale-125 transition-transform duration-700">
                                    <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.2 3.2.8-1.3-4.5-2.7V7z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-black font-outfit mb-6 relative z-10">Activités Récentes</h3>
                                <div class="space-y-6 relative z-10">
                                    @forelse($recentBookings as $booking)
                                        <div
                                            class="flex items-center gap-4 bg-white/5 p-4 rounded-2xl border border-white/5 hover:bg-white/10 transition">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-coral-500/20 text-coral-400 flex items-center justify-center text-xs font-black">
                                                {{ $booking->tickets_count }}
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs font-black text-white truncate">{{ $booking->user_name }}</p>
                                                <p class="text-[9px] text-white/40 font-bold uppercase tracking-tighter">
                                                    {{ $booking->event->title ?? 'Événement' }}</p>
                                            </div>
                                            <div class="text-[10px] font-black text-coral-400">
                                                +{{ number_format(($booking->tickets_count * ($booking->ticketType->price ?? 0)), 0, ',', ' ') }}
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-white/30 text-xs italic font-medium">Aucune activité enregistrée.</p>
                                    @endforelse
                                </div>
                                <a href="{{ route('organizer.events.index') }}"
                                    class="mt-8 block text-center py-4 bg-white/10 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-white hover:text-slate-900 transition">Voir
                                    tous mes événements</a>
                            </div>

                            <div class="bg-coral-600 rounded-[3rem] p-8 text-white relative overflow-hidden group">
                                <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                                <h3 class="text-lg font-black font-outfit mb-2 relative z-10 text-white">Prêt à briller ?
                                </h3>
                                <p class="text-white/70 text-sm font-medium leading-relaxed relative z-10 mb-6">Ajoutez de
                                    nouvelles catégories VIP pour booster vos ventes.</p>
                                <a href="{{ route('organizer.events.create') }}"
                                    class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-widest bg-white text-coral-600 px-6 py-3 rounded-xl hover:scale-105 transition transform">Nouveau
                                    Ticket</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'organizer')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const chartData = {!! json_encode($chartData ?? array_fill(0, 6, 0)) !!};
                const labels = Auth.user.role === 'admin'
                    ? ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc']
                    : ['M-5', 'M-4', 'M-3', 'M-2', 'M-1', 'Aujourd\'hui'];

                // ADMIN CHART (if exists)
                const adminCtx = document.getElementById('salesChart');
                if (adminCtx) {
                    new Chart(adminCtx.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Réservations',
                                data: chartData,
                                borderColor: '#ed3314',
                                backgroundColor: 'rgba(237, 51, 20, 0.08)',
                                fill: true,
                                tension: 0.4,
                                borderWidth: 4,
                            }]
                        },
                        options: { responsive: true, plugins: { legend: { display: false } } }
                    });
                }

                // ORGANIZER CHART (if exists)
                const orgCtx = document.getElementById('organizerChart');
                if (orgCtx) {
                    new Chart(orgCtx.getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: ['M-5', 'M-4', 'M-3', 'M-2', 'M-1', 'Aujourd\'hui'],
                            datasets: [{
                                label: 'Réservations',
                                data: chartData,
                                backgroundColor: '#ed3314',
                                borderRadius: 12,
                                barThickness: 20,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                y: { beginAtZero: true, grid: { color: '#f1f5f9', borderDash: [5, 5] }, ticks: { font: { size: 10, weight: '900' } } },
                                x: { grid: { display: false }, ticks: { font: { size: 10, weight: '900' } } }
                            }
                        }
                    });
                }
            });

            // Petite variable pour le script JS
            window.Auth = {
                user: {
                    role: '{{ Auth::user()->role }}'
                }
            };
        </script>
    @endif
</x-app-layout>