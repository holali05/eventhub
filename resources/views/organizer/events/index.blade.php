<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%; padding: 10px 0;">
            <h2 style="font-weight: 900; font-size: 1.875rem; color: #1e293b; margin: 0;">
                {{ __('Mes Événements') }}
            </h2>
            
            <a href="{{ route('organizer.events.create') }}" 
               style="background-color: #4f46e5 !important; color: #ffffff !important; padding: 12px 24px; border-radius: 16px; font-weight: 900; text-decoration: none; display: inline-flex; align-items: center; box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4); text-transform: uppercase; font-size: 0.875rem;">
                <span style="font-size: 1.25rem; margin-right: 8px;">+</span>
                CRÉER UN ÉVÉNEMENT
            </a>
        </div>
    </x-slot>

    <div class="py-12" style="background-color: #f8fafc; min-height: 100vh;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse($myEvents as $event)
                    <div style="background: white; border-radius: 40px; overflow: hidden; border: 1px solid #f1f5f9; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05); display: flex; flex-direction: column; position: relative;">
                        
                        {{-- Image de couverture (Corrigée pour public/uploads) --}}
                        <div style="position: relative; height: 200px;">
                            @if($event->image_path)
                                <img src="{{ asset($event->image_path) }}" style="width: 100%; height: 100%; object-fit: cover;" alt="{{ $event->title }}">
                            @else
                                <div style="width: 100%; height: 100%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold;">PAS D'IMAGE</div>
                            @endif
                            
                            <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);"></div>
                            
                            {{-- Statut Dynamique --}}
                            <div style="position: absolute; top: 20px; left: 20px;">
                                @if($event->admin_status === 'approved')
                                    <span style="background: rgba(16, 185, 129, 0.2); color: #34d399; padding: 6px 16px; border-radius: 9999px; font-size: 10px; font-weight: 900; text-transform: uppercase; border: 1px solid rgba(16, 185, 129, 0.3); backdrop-filter: blur(4px);">● Live</span>
                                @elseif($event->admin_status === 'refused')
                                    <span style="background: rgba(244, 63, 94, 0.2); color: #fb7185; padding: 6px 16px; border-radius: 9999px; font-size: 10px; font-weight: 900; text-transform: uppercase; border: 1px solid rgba(244, 63, 94, 0.3); backdrop-filter: blur(4px);">🚫 Refusé</span>
                                @else
                                    <span style="background: rgba(245, 158, 11, 0.2); color: #fbbf24; padding: 6px 16px; border-radius: 9999px; font-size: 10px; font-weight: 900; text-transform: uppercase; border: 1px solid rgba(245, 158, 11, 0.3); backdrop-filter: blur(4px);">⏳ En attente</span>
                                @endif
                            </div>
                        </div>

                        {{-- Infos Événement --}}
                        <div style="padding: 30px;">
                            <h3 style="font-weight: 900; font-size: 1.5rem; color: #1e293b; margin-bottom: 5px;">{{ $event->title }}</h3>
                            <p style="color: #94a3b8; font-weight: 700; font-size: 10px; text-transform: uppercase; margin-bottom: 15px;">📍 {{ $event->location }}</p>

                            {{-- Motif de refus --}}
                            @if($event->admin_status === 'refused' && $event->rejection_reason)
                                <div style="background-color: #fff1f2; color: #e11d48; padding: 12px; border-radius: 15px; font-size: 11px; font-weight: 700; margin-bottom: 20px; border-left: 4px solid #e11d48;">
                                    ⚠️ Motif : {{ $event->rejection_reason }}
                                </div>
                            @endif

                            <p style="font-size: 9px; font-weight: 900; color: #cbd5e1; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">Billets proposés</p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 25px;">
                                @foreach($event->ticketTypes as $ticket)
                                    <div style="background: #f8fafc; border: 1px solid #f1f5f9; padding: 8px 12px; border-radius: 12px; min-width: 90px;">
                                        <div style="font-size: 8px; font-weight: 800; color: #64748b; text-transform: uppercase;">{{ $ticket->name }}</div>
                                        <div style="font-size: 12px; font-weight: 900; color: #4f46e5;">{{ number_format($ticket->price, 0, ',', ' ') }} <small>CFA</small></div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Statistiques --}}
                            <div style="border-top: 1px solid #f1f5f9; padding-top: 20px;">
                                <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 8px;">
                                    <span style="font-weight: 900; font-size: 1.5rem; color: #1e293b;">{{ $event->total_tickets_sold ?? 0 }} <small style="font-size: 10px; color: #94a3b8; text-transform: uppercase;">Vendus</small></span>
                                    <span style="color: #4f46e5; font-weight: 900; font-size: 12px;">{{ $event->fill_rate ?? 0 }}%</span>
                                </div>
                                <div style="width: 100%; background: #f1f5f9; height: 8px; border-radius: 10px; overflow: hidden;">
                                    <div style="width: {{ $event->fill_rate ?? 0 }}%; background: linear-gradient(to right, #6366f1, #a855f7); height: 100%; border-radius: 10px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 80px 0;">
                        <p style="color: #94a3b8; font-weight: bold;">Vous n'avez pas encore créé d'événement.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>