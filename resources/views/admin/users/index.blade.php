<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des Comptes Organisateurs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-lg font-bold mb-6 text-indigo-600">Comptes en attente d'approbation</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 border-b text-left text-xs font-bold uppercase text-gray-500">Nom</th>
                                <th class="px-6 py-3 border-b text-left text-xs font-bold uppercase text-gray-500">Email</th>
                                <th class="px-6 py-3 border-b text-center text-xs font-bold uppercase text-gray-500">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users->where('is_approved', false) as $user)
                                <tr>
                                    <td class="px-6 py-4 border-b">{{ $user->name }}</td>
                                    <td class="px-6 py-4 border-b">{{ $user->email }}</td>
                                    <td class="px-6 py-4 border-b text-center">
                                        <form action="{{ route('admin.users.approve', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full text-xs transition">
                                                Approuver le compte
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-10 text-center text-gray-400 italic">
                                        Aucun compte en attente d'approbation.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>