<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes Inscriptions aux Événements') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if($bookings->isEmpty())
                    <p class="text-gray-500 text-center">Vous n'avez pas encore de réservations.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b bg-gray-50">
                                    <th class="p-3 text-sm font-semibold text-gray-700">Événement</th>
                                    <th class="p-3 text-sm font-semibold text-gray-700">Date</th>
                                    <th class="p-3 text-sm font-semibold text-gray-700">Places</th>
                                    <th class="p-3 text-sm font-semibold text-gray-700">Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                    <tr class="border-b hover:bg-gray-50 transition">
                                        <td class="p-3 font-medium text-indigo-600">
                                            {{ $booking->event->title }}
                                        </td>
                                        <td class="p-3 text-sm text-gray-600">
                                            {{ \Carbon\Carbon::parse($booking->event->event_date)->format('d/m/Y') }}
                                        </td>
                                        <td class="p-3 text-sm">
                                            <span class="px-2 py-1 bg-gray-100 rounded-full">{{ $booking->tickets_count }}</span>
                                        </td>
                                        <td class="p-3">
                                            <span class="text-xs font-bold uppercase px-2 py-1 rounded bg-green-100 text-green-700">
                                                {{ $booking->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>