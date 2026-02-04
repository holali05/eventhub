<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-lg shadow">
                <h2 class="text-2xl font-bold mb-6">Créer un nouvel événement</h2>
                
                <form action="/organizer/events" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid gap-4">
                        <div>
                            <label class="block font-bold">Titre de l'événement</label>
                            <input type="text" name="title" class="w-full border-gray-300 rounded shadow-sm" required>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block font-bold">Date</label>
                                <input type="date" name="event_date" class="w-full border-gray-300 rounded shadow-sm" required>
                            </div>
                            <div>
                                <label class="block font-bold">Lieu</label>
                                <input type="text" name="location" class="w-full border-gray-300 rounded shadow-sm" required>
                            </div>
                        </div>
                        <div>
                            <label class="block font-bold">Description</label>
                            <textarea name="description" class="w-full border-gray-300 rounded shadow-sm"></textarea>
                        </div>
                        <div>
                            <label class="block font-bold">Modèle du Ticket (Image)</label>
                            <input type="file" name="ticket_template" class="w-full border-gray-300">
                        </div>
                        <button type="submit" class="mt-4 bg-green-600 text-white py-3 rounded-lg font-bold shadow-lg">
                            Enregistrer et envoyer pour validation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>