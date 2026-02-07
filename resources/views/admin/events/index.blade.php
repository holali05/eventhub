<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Validation des Événements') }}
            </h2>
            <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                Contrôle des publications
            </span>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 text-green-700 shadow-sm">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-200">
                <div class="p-0 overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Événement</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Organisateur</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($events as $event)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $event->title }}</div>
                                        <div class="text-xs text-gray-500">{{ Str::limit($event->description, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-600 font-medium">
                                            {{ $event->user->name ?? 'Inconnu' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($event->is_published)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Public</span>
                                        @elseif($event->admin_status === 'rejected')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Refusé</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">En attente</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end space-x-2" x-data="{ showModal: false }">
                                            {{-- BOUTON PUBLIER --}}
                                            @if(!$event->is_published)
                                                <form action="{{ route('admin.events.approve', $event) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                                        Publier
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- BOUTON REFUSER (Ouvre le modal) --}}
                                            @if($event->admin_status !== 'rejected')
                                                <button @click="showModal = true" class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                                    Refuser
                                                </button>
                                            @endif

                                            {{-- MODAL DE REFUS --}}
                                            <div x-show="showModal" 
                                                 class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                                                 style="display: none;">
                                                <div class="bg-white p-6 rounded-xl shadow-2xl w-full max-w-md text-left">
                                                    <h3 class="text-lg font-bold text-gray-900 mb-2">Refuser l'événement</h3>
                                                    <p class="text-sm text-gray-500 mb-4">Veuillez indiquer à l'organisateur pourquoi son événement est refusé.</p>
                                                    
                                                    <form action="{{ route('admin.events.refuse', $event) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <textarea name="reason" rows="4" 
                                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" 
                                                            placeholder="Ex: La description est trop courte ou les images sont inappropriées..." required></textarea>
                                                        
                                                        <div class="mt-5 flex justify-end space-x-3">
                                                            <button type="button" @click="showModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                                                                Annuler
                                                            </button>
                                                            <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-red-600 rounded-lg hover:bg-red-700 shadow-sm">
                                                                Confirmer le refus
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">Aucun événement à gérer.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>