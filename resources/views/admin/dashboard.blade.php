<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes Événements') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold">Liste de mes créations</h3>
                <a href="/organizer/events/create" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow font-bold transition">
                    + Créer un événement
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($myEvents as $event)
                    <div class="bg-white border rounded-xl p-4 shadow-sm hover:shadow-md transition">
                        <h4 class="font-bold text-lg text-indigo-900">{{ $event->title }}</h4>
                        <p class="text-gray-500 text-sm mb-3">📍 {{ $event->location }}</p>
                        
                        <div class="flex justify-between items-center">
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $event->status == 'approved' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                {{ $event->status == 'approved' ? 'Approuvé' : 'En attente' }}
                            </span>
                            
                            <a href="#" class="text-xs text-indigo-600 hover:underline">Gérer</a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-8 rounded-xl border-2 border-dashed text-center">
                        <p class="text-gray-500 italic">Aucun événement trouvé pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>