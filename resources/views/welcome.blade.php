<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventHub - Accueil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900">
    <nav class="p-6 bg-white shadow-sm flex justify-between items-center">
        <h1 class="text-2xl font-black text-indigo-600">EventHub</h1>
        <div>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/organizer/dashboard') }}" class="font-bold text-slate-600 hover:text-indigo-600">Mon Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="mr-4 font-bold text-slate-600">Connexion</a>
                    <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-bold">S'inscrire</a>
                @endauth
            @endif
        </div>
    </nav>

    <main class="container mx-auto py-12 px-4">
        <h2 class="text-4xl font-bold mb-8 text-center">Événements à la une</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($events as $event)
                <div class="bg-white rounded-2xl shadow-sm border p-4 overflow-hidden">
                    @if($event->ticket_template)
                        <img src="{{ asset('storage/' . $event->ticket_template) }}" class="w-full h-48 object-cover rounded-xl mb-4">
                    @endif
                    <h3 class="text-xl font-bold">{{ $event->title }}</h3>
                    <p class="text-slate-500 mb-4 text-sm">📍 {{ $event->location }}</p>
                    <p class="text-slate-400 text-xs">{{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y H:i') }}</p>
                </div>
            @empty
                <div class="col-span-full text-center py-20 bg-white rounded-3xl border-2 border-dashed border-slate-200">
                    <p class="text-slate-400">Aucun événement n'est disponible pour le moment.</p>
                </div>
            @endforelse
        </div>
    </main>
</body>
</html>