<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Événement - EventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen">

    <div class="container mx-auto py-12 px-4 max-w-3xl">
        {{-- Lien de retour vers le dashboard --}}
        <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-800 font-bold flex items-center gap-2 mb-6">
            ← Retour au dashboard
        </a>

        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            {{-- En-tête --}}
            <div class="bg-indigo-600 p-8 text-white">
                <h2 class="text-3xl font-bold">Nouvel Événement</h2>
                <p class="opacity-80">Remplissez les détails pour soumettre votre événement à l'admin.</p>
            </div>

            {{-- Formulaire --}}
            <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Titre --}}
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Titre de l'événement</label>
                        <input type="text" name="title" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition" placeholder="Ex: Concert de Gala">
                    </div>

                    {{-- DATE ET HEURE (CORRIGÉ) --}}
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Date et Heure</label>
                        <input type="datetime-local" 
                               id="event_date"
                               name="event_date" 
                               required 
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition">
                    </div>
                </div>

                {{-- Lieu --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Lieu</label>
                    <input type="text" name="location" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition" placeholder="Ex: Palais des Congrès, Cotonou">
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition" placeholder="Détails de l'événement..."></textarea>
                </div>

                <hr class="border-slate-100">

                {{-- Image Ticket --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">🖼️ Modèle de Ticket (Template)</label>
                    <p class="text-xs text-slate-400 mb-3">L'image de fond sur laquelle le QR Code sera généré.</p>
                    <input type="file" name="ticket_template" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>

                <hr class="border-slate-100">

                {{-- WhatsApp --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">📱 Contacts WhatsApp</label>
                    <p class="text-xs text-slate-400 mb-3">Entrez les numéros (un par ligne).</p>
                    <textarea name="contact_list" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition" placeholder="Ex: 22997000000"></textarea>
                </div>

                {{-- Bouton de soumission --}}
                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-4 rounded-2xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                    🚀 Créer et envoyer pour validation
                </button>
            </form>
        </div>
    </div>

    {{-- Script pour empêcher de choisir une date passée --}}
    <script>
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        document.getElementById('event_date').min = now.toISOString().slice(0,16);
    </script>

</body>
</html>