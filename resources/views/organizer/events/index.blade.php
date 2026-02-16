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
                        
                        {{-- Image de couverture --}}
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
                        <div style="padding: 30px; flex-grow: 1; display: flex; flex-direction: column;">
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

                            {{-- BOUTON D'IMPORTATION WHATSAPP UNIQUEMENT --}}
                            <div style="margin-top: auto; padding-top: 20px; border-top: 1px solid #f1f5f9;">
                                <form action="{{ route('whatsapp.import') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                    <label style="background: linear-gradient(135deg, #25D366 0%, #128C7E 100%) !important; 
                                                  color: #ffffff !important; 
                                                  width: 100%; 
                                                  padding: 14px; 
                                                  border-radius: 18px; 
                                                  font-weight: 900; 
                                                  display: flex; 
                                                  align-items: center; 
                                                  justify-content: center; 
                                                  gap: 10px;
                                                  box-shadow: 0 10px 15px -3px rgba(37, 211, 102, 0.3); 
                                                  text-transform: uppercase; 
                                                  font-size: 0.75rem; 
                                                  cursor: pointer; 
                                                  transition: transform 0.2s;
                                                  border: none;"
                                           onmouseover="this.style.transform='scale(1.02)'" 
                                           onmouseout="this.style.transform='scale(1)'">
                                        
                                        <svg style="height: 18px; width: 18px;" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                        </svg>
                                        IMPORTER CONTACTS
                                        <input type="file" name="csv_file" accept=".csv" style="display: none;" onchange="this.form.submit()">
                                    </label>
                                </form>
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