<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mes Événements</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold">Liste de mes créations</h3>
                <a href="/organizer/events/create" class="bg-indigo-600 text-white px-4 py-2 rounded shadow font-bold">
                    + Créer un événement
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($myEvents as $event)
                    <div class="bg-white border rounded-xl p-4 shadow-sm">
                        <h4 class="font-bold text-lg">{{ $event->title }}</h4>
                        <p class="text-gray-500 text-sm mb-3">{{ $event->location }}</p>
                        <span class="px-2 py-1 rounded text-xs {{ $event->status == 'approved' ? 'bg-green-100' : 'bg-orange-100' }}">
                            {{ $event->status }}
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500 italic">Aucun événement trouvé.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>