<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EventHub | Découvrez les meilleurs événements</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-outfit {
            font-family: 'Outfit', sans-serif;
        }

        .event-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .event-card:hover {
            transform: translateY(-8px);
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>

<body class="antialiased text-slate-900 selection:bg-coral-100 selection:text-coral-700">

    <!-- Decorative background -->
    <div class="fixed top-0 inset-0 -z-10 overflow-hidden pointer-events-none">
        <div
            class="absolute -top-20 -left-20 w-[600px] h-[600px] bg-coral-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob pointer-events-none">
        </div>
        <div
            class="absolute top-20 -right-20 w-[500px] h-[500px] bg-amber-300 rounded-full mix-blend-multiply filter blur-3xl opacity-25 animate-blob animation-delay-2000 pointer-events-none">
        </div>
    </div>

    <header class="sticky top-0 z-50 glass-nav">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="group flex items-center gap-3">
                <x-application-logo class="w-10 h-10 transition-transform duration-200 group-hover:scale-110" />
                <span
                    class="text-3xl font-extrabold tracking-tight text-coral-600 font-outfit transition-transform duration-200 inline-block">Event<span
                        class="text-slate-900">Hub</span></span>
            </a>
            <nav class="flex items-center gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="px-5 py-2.5 bg-coral-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-coral-100 hover:bg-coral-700 transition">Tableau
                        de bord</a>
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm font-bold text-slate-600 hover:text-coral-600 px-4 py-2 transition">Connexion</a>
                    <a href="{{ route('register') }}"
                        class="px-6 py-2.5 bg-coral-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-coral-100 hover:bg-coral-700 transition">S'inscrire</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-12">
        <div class="mb-16 text-center max-w-3xl mx-auto animate-fade-up">
            <div
                class="inline-flex items-center gap-2 px-4 py-2 bg-white/80 backdrop-blur-sm rounded-full text-xs font-black uppercase tracking-widest text-coral-600 border border-coral-100 shadow-sm mb-6">
                <span class="w-2 h-2 rounded-full bg-coral-500 animate-ping-slow"></span>
                Événements disponibles maintenant
            </div>
            <h1 class="text-5xl font-extrabold text-slate-950 font-outfit mb-6 tracking-tight leading-tight">
                Découvrez les <span class="shimmer-text">meilleures
                    expériences</span><br>sélectionnées pour vous.
            </h1>
            <p class="text-lg text-slate-500 font-medium">Réservez vos places en quelques clics pour les événements les
                plus exclusifs.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse($events as $index => $event)
                <div class="event-card group bg-white rounded-4xl shadow-soft hover:shadow-coral border border-white/40 overflow-hidden flex flex-col h-full ring-1 ring-slate-100 animate-fade-up"
                    style="animation-delay: {{ ($index % 6) * 0.1 }}s">

                    <div class="relative h-64 overflow-hidden">
                        @if($event->image_path)
                            <img src="{{ asset($event->image_path) }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                alt="{{ $event->title }}" onerror="this.src='https://placehold.co/600x400?text=Event+Image'">
                        @else
                            <div
                                class="w-full h-full bg-gradient-to-br from-coral-500 to-amber-500 flex items-center justify-center text-white italic text-xs">
                                Pas d'image disponible
                            </div>
                        @endif

                        @if($event->admin_status === 'approved')
                            <div
                                class="absolute top-4 left-4 px-3 py-1.5 bg-white/90 backdrop-blur-md text-iris-600 rounded-lg text-[10px] font-black uppercase tracking-widest shadow-sm flex items-center gap-1.5 ring-1 ring-black/5">
                                <span class="w-1.5 h-1.5 rounded-full bg-iris-600 animate-pulse"></span>
                                Officiel
                            </div>
                        @endif

                        <div
                            class="absolute bottom-4 right-4 px-3 py-1 bg-black/40 backdrop-blur-md text-white rounded-lg text-[10px] font-bold uppercase tracking-widest">
                            {{ $event->location ?? 'Lieu à définir' }}
                        </div>
                    </div>

                    <div class="p-8 flex flex-col flex-grow">
                        <h3 class="text-2xl font-bold text-slate-900 mb-3 tracking-tight font-outfit">{{ $event->title }}
                        </h3>
                        <p class="text-slate-400 text-sm leading-relaxed line-clamp-2 mb-8 italic">
                            "{{ $event->description }}"</p>

                        <div class="mt-auto flex items-center justify-between pt-6 border-t border-slate-50">
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Prix dès</p>
                                <p class="text-2xl font-black text-slate-900 font-outfit">
                                    @if($event->ticketTypes && $event->ticketTypes->count() > 0)
                                        {{ number_format($event->ticketTypes->min('price'), 0, ',', ' ') }}
                                    @else
                                        0
                                    @endif
                                    <span class="text-xs font-bold text-iris-600 ml-1">CFA</span>
                                </p>
                            </div>
                            <a href="{{ route('events.show', $event->id) }}"
                                class="flex items-center justify-center w-12 h-12 bg-slate-900 group-hover:bg-iris-600 text-white rounded-2xl transition-colors shadow-lg hover:shadow-iris-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full py-32 text-center bg-white rounded-4xl border border-dashed border-slate-200 shadow-soft">
                    <div
                        class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center mx-auto mb-6 text-slate-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <p class="text-lg font-bold text-slate-900 mb-2">Aucun événement disponible</p>
                    <p class="text-slate-500">Revenez plus tard pour découvrir nos nouveautés.</p>
                </div>
            @endforelse
        </div>
    </main>

    {{-- Animations defined in resources/css/app.css --}}
</body>

</html>