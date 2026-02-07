<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-slate-200">
                
                <div class="bg-indigo-600 p-6 text-white text-center">
                    <h2 class="text-2xl font-bold">Créer un Nouvel Événement</h2>
                </div>

                <form action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Titre de l'événement</label>
                            <input type="text" name="title" required placeholder="Ex: Gala ESGIS" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Capacité totale</label>
                            <input type="number" name="capacity" required min="1" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none shadow-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Date</label>
                            <input type="date" name="event_date" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Heure</label>
                            <input type="time" name="event_time" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none shadow-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Lieu</label>
                        <input type="text" name="location" required placeholder="Ex: Campus ESGIS" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                        <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none shadow-sm"></textarea>
                    </div>

                    {{-- --- NOUVEAU : SECTION PHOTO DE COUVERTURE --- --}}
                    <div class="p-4 bg-indigo-50 rounded-2xl border border-indigo-100">
                        <label class="block text-sm font-bold text-indigo-900 mb-2">📸 Photo de l'événement (Couverture)</label>
                        <p class="text-[11px] text-indigo-600 mb-3">C'est cette image qui sera visible sur la page d'accueil par tout le monde.</p>
                        <input type="file" name="image" required accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer">
                    </div>

                    {{-- --- SECTION DYNAMIQUE DES TICKETS --- --}}
                    <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 space-y-4">
                        <div class="flex justify-between items-center border-b border-slate-200 pb-3">
                            <h3 class="text-lg font-bold text-indigo-900">🎟️ Configuration des Billets</h3>
                            <button type="button" id="add-ticket" class="bg-indigo-600 text-white text-xs px-4 py-2 rounded-lg font-bold hover:bg-indigo-700 transition">
                                + Ajouter un type
                            </button>
                        </div>

                        <div id="tickets-container" class="space-y-4">
                            <div class="grid grid-cols-3 gap-4 p-4 bg-white rounded-xl border border-slate-100 shadow-sm ticket-row">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase">Nom (ex: Standard)</label>
                                    <input type="text" name="tickets[0][name]" required class="w-full mt-1 border-slate-200 rounded-lg text-sm focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase">Prix (CFA)</label>
                                    <input type="number" name="tickets[0][price]" required min="0" class="w-full mt-1 border-slate-200 rounded-lg text-sm focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase">Quantité</label>
                                    <input type="number" name="tickets[0][total_quantity]" required min="1" class="w-full mt-1 border-slate-200 rounded-lg text-sm focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Modèle de Ticket (Image pour le PDF)</label>
                        <input type="file" name="ticket_template" required accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300">
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-4 rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                        🚀 Créer l'événement
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let ticketIndex = 1;
        document.getElementById('add-ticket').addEventListener('click', function() {
            const container = document.getElementById('tickets-container');
            const newRow = document.createElement('div');
            newRow.className = "grid grid-cols-3 gap-4 p-4 bg-white rounded-xl border border-slate-100 shadow-sm ticket-row relative";
            newRow.innerHTML = `
                <div>
                    <input type="text" name="tickets[${ticketIndex}][name]" placeholder="Nom" required class="w-full border-slate-200 rounded-lg text-sm">
                </div>
                <div>
                    <input type="number" name="tickets[${ticketIndex}][price]" placeholder="Prix" required class="w-full border-slate-200 rounded-lg text-sm">
                </div>
                <div class="flex items-center gap-2">
                    <input type="number" name="tickets[${ticketIndex}][total_quantity]" placeholder="Qté" required class="w-full border-slate-200 rounded-lg text-sm">
                    <button type="button" onclick="this.closest('.ticket-row').remove()" class="text-red-500 font-bold">✕</button>
                </div>
            `;
            container.appendChild(newRow);
            ticketIndex++;
        });
    </script>
</x-app-layout>