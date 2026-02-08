<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-orange-800 leading-tight">Espace Modération Admin</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border">
                <h3 class="text-lg font-bold mb-6 text-gray-700">Événements en attente :</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 uppercase text-sm">
                                <th class="p-3 border">Titre</th>
                                <th class="p-3 border text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingEvents as $event)
                            <tr class="hover:bg-gray-50 border-b">
                                <td class="p-3 font-semibold">{{ $event->title }}</td>
                                <td class="p-3">
                                    <div class="flex justify-center gap-4">
                                        <form action="{{ route('admin.approve-event', $event->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded shadow-sm font-bold transition">
                                                Approuver
                                            </button>
                                        </form>

                                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-100 text-red-600 hover:bg-red-200 px-6 py-2 rounded font-bold transition">
                                                Refuser
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="p-12 text-center">
                                    <div class="text-gray-400">
                                        <p class="text-5xl mb-4">🎫</p>
                                        <p class="text-xl font-medium">Aucun événement à modérer.</p>
                                        <p class="text-sm">Vérifiez que vos événements créés ont bien le statut 'pending' en base de données.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    <a href="/dashboard" class="text-indigo-600 hover:underline">← Retour au tableau de bord</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>