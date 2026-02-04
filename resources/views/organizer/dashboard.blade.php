<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white p-6 rounded-lg shadow-sm border mb-6">
                <h3 class="text-lg font-bold">Bienvenue, {{ auth()->user()->name }}</h3>
                <p class="text-gray-600">Gérez vos activités et vos événements en toute simplicité.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="p-6 bg-white border rounded-xl shadow-sm">
                    <h4 class="font-bold mb-2">Gestion Événements</h4>
                    <p class="text-sm text-gray-500 mb-4">Accédez à votre espace pour créer et voir vos événements.</p>
                    <a href="/organizer/dashboard" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded font-bold hover:bg-indigo-700 transition">
                        Mes Événements
                    </a>
                </div>

                @if(auth()->user()->id == 1) 
                <div class="p-6 bg-white border-2 border-orange-500 rounded-xl shadow-sm bg-orange-50">
                    <h4 class="font-bold mb-2 text-orange-600">Administration</h4>
                    <p class="text-sm text-gray-500 mb-4">Valider les nouveaux événements soumis sur la plateforme.</p>
                    <a href="/admin/moderation" class="inline-block bg-orange-500 text-white px-4 py-2 rounded font-bold hover:bg-orange-600 transition">
                        Modération Admin
                    </a>
                </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>