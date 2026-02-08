<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-slate-800 leading-tight tracking-tighter">
                {{ __('Tableau de bord') }}
            </h2>
            <span class="px-4 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold uppercase tracking-widest">
                Session : {{ ucfirst(Auth::user()->role) }}
            </span>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(Auth::user()->role === 'admin')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
                    <div class="bg-white p-8 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 flex items-center justify-between">
                        <div>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Utilisateurs</p>
                            <h3 class="text-4xl font-black text-slate-900">{{ $totalUsers }}</h3>
                        </div>
                        <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 flex items-center justify-between">
                        <div>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Événements</p>
                            <h3 class="text-4xl font-black text-slate-900">{{ $totalEvents }}</h3>
                        </div>
                        <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 flex items-center justify-between">
                        <div>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Tickets Vendus</p>
                            <h3 class="text-4xl font-black text-slate-900">{{ $totalBookings }}</h3>
                        </div>
                        <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 mb-10">
                    <h3 class="font-black text-xl text-slate-800 mb-6 flex items-center gap-2">
                        <span class="w-2 h-6 bg-indigo-600 rounded-full"></span>
                        Analyse des réservations
                    </h3>
                    <canvas id="salesChart" height="80"></canvas>
                </div>

                <div class="bg-white p-8 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 mb-10">
                    <h3 class="font-black text-xl text-slate-800 mb-6 flex items-center gap-2">
                        <span class="w-2 h-6 bg-orange-500 rounded-full"></span>
                        Taux de remplissage (Top Événements)
                    </h3>
                    <div class="space-y-6">
                        @forelse($topEvents ?? [] as $event)
                            <div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-sm font-bold text-slate-700">{{ $event->title }}</span>
                                    <span class="text-sm font-black text-indigo-600">{{ $event->fill_rate }}%</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-3">
                                    <div class="bg-indigo-600 h-3 rounded-full shadow-md" style="width: {{ $event->fill_rate }}%"></div>
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

                <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden mb-10">
                    <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                        <h3 class="font-black text-xl text-slate-800">Dernières demandes d'approbation</h3>
                        <a href="{{ route('admin.events.index') }}" class="text-indigo-600 font-bold text-sm hover:underline">Voir tout</a>
                    </div>
                    <div class="p-0">
                        @forelse($pendingEvents as $event)
                            <div class="p-6 border-b border-slate-50 flex items-center justify-between hover:bg-slate-50 transition">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden">
                                        <img src="{{ asset($event->image_path) }}" class="w-full h-full object-cover" onerror="this.src='https://placehold.co/100x100'">
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $event->title }}</p>
                                        <p class="text-xs text-slate-400 italic">Par {{ $event->user->name ?? 'Inconnu' }}</p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <form action="{{ route('admin.events.approve', $event) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="px-4 py-2 bg-emerald-500 text-white rounded-xl text-xs font-black shadow-lg shadow-emerald-100 hover:bg-emerald-600">Approuver</button>
                                    </form>
                                    <form action="{{ route('admin.events.refuse', $event) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="px-4 py-2 bg-red-500 text-white rounded-xl text-xs font-black shadow-lg shadow-red-100 hover:bg-red-600">Refuser</button>
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
                <div class="text-center py-20 bg-white rounded-[3rem] border border-slate-100 shadow-xl">
                   <h3 class="text-2xl font-black text-slate-800 mb-4">Bienvenue, {{ Auth::user()->name }} !</h3>
                   <p class="text-slate-500 mb-8">Vous avez actuellement <span class="text-indigo-600 font-bold">{{ $myEventsCount }} événement(s)</span> en ligne.</p>
                   <a href="{{ route('organizer.events.create') }}" class="px-8 py-4 bg-indigo-600 text-white rounded-full font-black shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition">Créer un nouvel événement</a>
                </div>
            @endif

        </div>
    </div>

    @if(Auth::user()->role === 'admin')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            const chartData = {!! json_encode($chartData ?? array_fill(0, 12, 0)) !!};

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
                    datasets: [{
                        label: 'Réservations',
                        data: chartData,
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 4,
                        pointRadius: 4,
                        pointBackgroundColor: '#fff',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        });
    </script>
    @endif
</x-app-layout>