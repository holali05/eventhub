<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-slate-900 font-outfit tracking-tight">Mes <span class="shimmer-text">Réservations</span></h2>
        <p class="text-slate-500 font-medium mt-1">Retrouvez tous vos accès pour vos événements à venir.</p>
    </x-slot>

    <div class="py-12 min-h-screen">
        <div class="max-w-7xl mx-auto px-6">
            
            @if($bookings->isEmpty())
                <div class="bg-white/80 backdrop-blur-sm rounded-4xl shadow-soft border border-white/40 p-12 text-center max-w-lg mx-auto animate-fade-up">
                    <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center mx-auto mb-6 text-slate-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Aucune réservation</h3>
                    <p class="text-slate-500 mb-8">Vous n'avez pas encore réservé de place pour un événement.</p>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-coral-600 text-white rounded-2xl font-bold shadow-lg shadow-coral-100 hover:bg-coral-700 transition">
                        Explorer les événements
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($bookings as $index => $booking)
                        <div class="group bg-white/80 backdrop-blur-sm rounded-4xl shadow-soft border border-white/40 overflow-hidden hover:shadow-xl transition-all duration-300 animate-fade-up"
                             style="animation-delay: {{ $index * 0.1 }}s">
                            <div class="relative h-40 overflow-hidden">
                                @if($booking->event->image_path)
                                    <img src="{{ asset($booking->event->image_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" alt="{{ $booking->event->title }}">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-coral-500 to-amber-400"></div>
                                @endif
                                <div class="absolute top-4 right-4 px-4 py-1.5 bg-white/20 backdrop-blur-md rounded-xl text-white text-[10px] font-black uppercase tracking-widest border border-white/20">
                                    {{ $booking->status }}
                                </div>
                            </div>
                            
                            <div class="p-8">
                                <div class="flex items-center gap-2 mb-4">
                                     <span class="px-3 py-1 bg-coral-50 text-coral-600 rounded-lg text-[10px] font-black uppercase tracking-widest border border-coral-100">
                                        {{ $booking->ticketType->name ?? 'Standard' }}
                                     </span>
                                     <span class="text-slate-400 font-bold text-xs">•</span>
                                     <span class="text-slate-500 font-bold text-xs">{{ $booking->tickets_count }} place{{ $booking->tickets_count > 1 ? 's' : '' }}</span>
                                </div>

                                <h3 class="text-xl font-bold text-slate-900 font-outfit mb-2 line-clamp-1">{{ $booking->event->title }}</h3>
                                
                                <div class="space-y-3 mb-8">
                                    <div class="flex items-center gap-3 text-slate-500">
                                        <svg class="w-4 h-4 text-coral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="text-sm font-medium">{{ \Carbon\Carbon::parse($booking->event->event_date)->translatedFormat('d M Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-3 text-slate-500">
                                        <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span class="text-sm font-medium truncate">{{ $booking->event->location }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-6 border-t border-slate-50">
                                    <div>
                                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Total Payé</p>
                                        <p class="text-lg font-black text-slate-950 font-outfit">{{ number_format($booking->tickets_count * ($booking->ticketType->price ?? 0), 0, ',', ' ') }} <span class="text-xs font-bold text-coral-600">CFA</span></p>
                                    </div>
                                    @if($booking->unique_hash)
                                        <a href="{{ route('tickets.download', $booking->unique_hash) }}" target="_blank"
                                            class="w-12 h-12 bg-slate-950 text-white rounded-2xl flex items-center justify-center hover:bg-coral-600 transition shadow-lg shadow-slate-200 group/btn">
                                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m7-7m-7 7H3"></path></svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>