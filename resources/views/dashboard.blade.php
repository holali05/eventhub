<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tableau de Bord</h2>
        
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow border-b-4 border-indigo-500">
                    <h5 class="text-gray-500 text-xs uppercase font-bold tracking-wider">Événements</h5>
                    <p class="text-3xl font-extrabold text-gray-800">{{ \App\Models\Event::count() }}</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow border-b-4 border-green-500">
                    <h5 class="text-gray-500 text-xs uppercase font-bold tracking-wider">Billets Vendus</h5>
                    <p class="text-3xl font-extrabold text-gray-800">142</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow border-b-4 border-orange-500">
                    <h5 class="text-gray-500 text-xs uppercase font-bold tracking-wider">Revenus</h5>
                    <p class="text-3xl font-extrabold text-gray-800">785.000 FCFA</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-xl shadow border">
                    <h4 class="font-bold text-indigo-600 text-lg mb-4">Espace Organisateur</h4>
                    <p class="text-sm text-gray-500 mb-6">Ajoutez de nouveaux événements.</p>
                    <a href="{{ route('events.create') }}" class="block w-full text-center bg-indigo-600 text-white py-3 rounded-lg font-bold hover:bg-indigo-700 transition">
                        + Créer un Événement
                    </a>
                </div>

                {{-- CHANGE LE CHIFFRE 1 PAR TON ID ADMIN (Regarde en haut à droite de ton écran) --}}
                @if(auth()->user()->id == 1) 
                <div class="bg-white p-6 rounded-xl shadow border-2 border-orange-500 bg-orange-50">
                    <h4 class="font-bold text-orange-600 text-lg mb-4">Modération Admin</h4>
                    <p class="text-sm text-gray-600 mb-6">Validez les événements en attente.</p>
                    <a href="{{ route('admin.moderation') }}" class="block w-full text-center bg-orange-500 text-white py-3 rounded-lg font-bold hover:bg-orange-600 transition">
                        Accéder à la Modération
                    </a>
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>