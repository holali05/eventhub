<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EventHub | Accueil</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .event-card { border-radius: 2rem; transition: all 0.3s ease; background: white; }
        .event-card:hover { transform: translateY(-5px); }
        .img-container { height: 224px; position: relative; background-color: #f1f5f9; overflow: hidden; }
        .img-event { width: 100%; height: 100%; object-fit: cover; }
    </style>
</head>
<body class="antialiased">
    
    <header class="max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">
        <h1 class="text-3xl font-black text-indigo-600 tracking-tighter">EventHub</h1>
        <nav class="flex items-center gap-4">
            @auth
                <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-indigo-600 border-b-2 border-indigo-600 px-2 py-1">Tableau de bord</a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-bold text-indigo-600 hover:bg-indigo-50 px-4 py-2 rounded-lg transition">Connexion</a>
                <a href="{{ route('register') }}" class="px-6 py-2 bg-indigo-600 text-white rounded-full text-sm font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">S'inscrire</a>
            @endauth
        </nav>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-10">
        <div class="mb-12">
            <h2 class="text-4xl font-black text-slate-900 mb-2">Événements <span class="text-indigo-600">à la une</span></h2>
            <p class="text-slate-500">Découvrez les meilleures expériences sélectionnées pour vous.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($events as $event)
                <div class="event-card shadow-xl shadow-slate-200/50 overflow-hidden border border-slate-100 flex flex-col h-full">
                    
                    <div class="img-container">
                        @if($event->image_path)
                            <img src="{{ asset($event->image_path) }}" 
                                 class="img-event" 
                                 alt="{{ $event->title }}"
                                 onerror="this.src='https://placehold.co/600x400?text=Image+Introuvable'">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300 italic text-xs">
                                Pas d'image disponible
                            </div>
                        @endif

                        @if($event->admin_status === 'approved')
                            <div class="absolute top-4 left-4 px-3 py-1 bg-indigo-600 text-white rounded-lg text-[10px] font-black uppercase tracking-widest shadow-lg">
                                Officiel
                            </div>
                        @endif
                    </div>

                    <div class="p-6 flex flex-col flex-grow">
                        <div class="text-indigo-600 font-black text-[10px] uppercase mb-2 tracking-widest">
                            {{ $event->location ?? 'Lieu à définir' }}
                        </div>

                        <h3 class="text-2xl font-black text-slate-900 mb-2 tracking-tight">{{ $event->title }}</h3>
                        <p class="text-slate-400 text-sm italic line-clamp-2 mb-6">"{{ $event->description }}"</p>

                        <div class="mt-auto flex items-center justify-between pt-4 border-t border-slate-50">
                            <div>
                                <p class="text-[9px] font-bold text-slate-300 uppercase tracking-widest">Prix dès</p>
                                <p class="text-xl font-black text-slate-900">
                                    @if($event->ticketTypes && $event->ticketTypes->count() > 0)
                                        {{ number_format($event->ticketTypes->min('price'), 0, ',', ' ') }}
                                    @else
                                        0
                                    @endif
                                    <span class="text-xs font-bold text-indigo-600 ml-1">CFA</span>
                                </p>
                            </div>
                            <a href="{{ route('events.show', $event->id) }}" class="p-3 bg-indigo-600 text-white rounded-xl hover:bg-slate-900 transition shadow-md">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-white rounded-3xl border-2 border-dashed border-slate-200 text-slate-400 italic font-medium">
                    Aucun événement disponible pour le moment.
                </div>
            @endforelse
        </div>
    </main>
</body>
</html>