<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $event->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-2xl font-bold text-indigo-900 mb-4">Détails de l'événement</h3>
                    <div class="space-y-3">
                        <p><strong>📍 Lieu :</strong> {{ $event->location }}</p>
                        <p><strong>📅 Date :</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }}</p>
                        <p><strong>⏰ Heure :</strong> {{ $event->event_time }}</p>
                        <hr class="my-4">
                        <p class="text-gray-700 leading-relaxed">
                            {{ $event->description ?? 'Aucune description disponible.' }}
                        </p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-indigo-600">
                    <h3 class="text-xl font-bold mb-4">Réserver ma place</h3>
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('bookings.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nom complet</label>
                            <input type="text" name="user_name" value="{{ Auth::user()->name }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Adresse Email</label>
                            <input type="email" name="user_email" value="{{ Auth::user()->email }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre de tickets</label>
                            <select name="tickets_count" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }} place{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                            Confirmer ma réservation
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>