<x-app-layout>
    <div class="relative min-h-screen bg-[#FAFAF8]">
        <!-- Hero Section with Background Image -->
        <div class="relative h-[40vh] md:h-[60vh] overflow-hidden">
            @if($event->image_path)
                <img src="{{ asset($event->image_path) }}" class="w-full h-full object-cover" alt="{{ $event->title }}">
            @else
                <div class="w-full h-full bg-gradient-to-br from-coral-500 to-amber-400"></div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-[#F8F9FF] via-transparent to-black/20"></div>

            <!-- Breadcrumbs / Back button -->
            <div class="absolute top-8 left-8 z-20">
                <a href="{{ route('home') }}"
                    class="flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-md rounded-xl text-white font-bold hover:bg-white/30 transition border border-white/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M10 19l-7-7m7-7m-7 7H21"></path>
                    </svg>
                    Retour
                </a>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 -mt-32 relative z-10 pb-20">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                <!-- Main Content (Left) -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white/80 backdrop-blur-sm rounded-4xl shadow-soft border border-white/40 p-8 md:p-12 animate-fade-up">
                        <div class="flex items-center gap-3 mb-6">
                            <span
                                class="px-4 py-1.5 bg-coral-50 text-coral-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-coral-100 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-coral-600 animate-pulse"></span>
                                Événement en direct
                            </span>
                            @if($event->admin_status === 'approved')
                                <span
                                    class="px-4 py-1.5 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-emerald-100">Certifié</span>
                            @endif
                        </div>

                        <h1
                            class="text-4xl md:text-5xl font-extrabold text-slate-900 font-outfit mb-6 tracking-tight leading-tight">
                            {{ $event->title }}
                        </h1>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
                            <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-3xl border border-slate-100">
                                <div
                                    class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-coral-600 shadow-sm">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Date</p>
                                    <p class="font-bold text-slate-900">
                                        {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('d M Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-3xl border border-slate-100">
                                <div
                                    class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-coral-600 shadow-sm">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Heure</p>
                                    <p class="font-bold text-slate-900">{{ $event->event_time }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-3xl border border-slate-100">
                                <div
                                    class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-rose-500 shadow-sm">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div class="truncate">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Lieu</p>
                                    <p class="font-bold text-slate-900 truncate">{{ $event->location }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="prose prose-slate max-w-none">
                            <h3 class="text-xl font-bold text-slate-900 mb-4 font-outfit">À propos de l'événement</h3>
                            <p class="text-slate-600 leading-relaxed italic border-l-4 border-coral-200 pl-6 py-2">
                                "{{ $event->description ?? 'Aucune description disponible pour cet événement.' }}"
                            </p>
                        </div>

                        <div class="mt-12 flex items-center gap-6 p-6 bg-coral-50 rounded-4xl border border-coral-100">
                            <div class="w-16 h-16 rounded-2xl bg-white overflow-hidden shadow-sm flex-shrink-0">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($event->user->name ?? 'Organizer') }}&background=ed3314&color=fff"
                                    class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-coral-400 uppercase tracking-widest mb-1">Organisé
                                    par</p>
                                <p class="font-bold text-slate-900 text-lg">
                                    {{ $event->user->name ?? 'Organisateur vérifié' }}
                                </p>
                            </div>
                            <a href="#"
                                class="ml-auto px-6 py-2 bg-white text-coral-600 rounded-xl text-sm font-bold shadow-sm hover:shadow-md transition">Suivre</a>
                        </div>
                    </div>
                </div>

                <!-- Sticky Booking Card (Right) -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-6">
                        <div
                            class="bg-white/80 backdrop-blur-sm rounded-4xl shadow-soft border border-white/40 overflow-hidden ring-1 ring-black/5 hover:ring-coral-200 transition-all duration-300 animate-fade-up delay-100">
                            <div class="p-8">
                                <div class="flex items-center justify-between mb-8">
                                    <h4 class="text-xl font-bold text-slate-900 font-outfit">Réserver</h4>
                                    <div
                                        class="bg-rose-50 text-rose-600 px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-widest">
                                        Places limitées</div>
                                </div>

                                <form action="{{ route('bookings.store') }}" method="POST" class="space-y-6" 
                                    x-data="{ 
                                        count: 1, 
                                        selectedPrice: {{ $event->ticketTypes->min('price') ?? 0 }},
                                        ticketTypeId: {{ $event->ticketTypes->first()->id ?? 'null' }},
                                        loading: false
                                    }"
                                    @submit="loading = true">
                                    @csrf
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                    <input type="hidden" name="ticket_type_id" :value="ticketTypeId">

                                    <div class="space-y-6">
                                        <div>
                                            <x-input-label value="Vos Informations" />
                                            <div class="space-y-3">
                                                <x-text-input name="user_name" type="text"
                                                    class="w-full bg-white border-slate-100"
                                                    placeholder="Nom complet" value="{{ Auth::check() ? Auth::user()->name : '' }}"
                                                    required />
                                                <x-text-input name="user_email" type="email"
                                                    class="w-full bg-white border-slate-100"
                                                    placeholder="Adresse Email" value="{{ Auth::check() ? Auth::user()->email : '' }}"
                                                    required />
                                            </div>
                                        </div>

                                        <div>
                                            <x-input-label value="Choisir votre expérience" />
                                            <div class="grid grid-cols-1 gap-4 mt-2">
                                                @foreach($event->ticketTypes as $type)
                                                    <div @click="ticketTypeId = {{ $type->id }}; selectedPrice = {{ $type->price }}"
                                                        class="relative p-5 rounded-3xl border-2 transition-all cursor-pointer group hover:shadow-lg hover:shadow-coral-100/20"
                                                        :class="ticketTypeId == {{ $type->id }} ? 'border-coral-600 bg-white ring-4 ring-coral-50' : 'border-slate-100 bg-slate-50 hover:border-coral-200'">
                                                        <div class="flex items-start justify-between">
                                                            <div class="flex-1">
                                                                <div class="flex items-center gap-3 mb-1">
                                                                    <span class="text-sm font-black text-slate-900 font-outfit uppercase tracking-tight leading-none">{{ $type->name }}</span>
                                                                    @if($type->remaining_quantity <= 10 && $type->remaining_quantity > 0)
                                                                        <span class="px-2 py-0.5 bg-rose-100 text-rose-600 text-[8px] font-black rounded-lg uppercase tracking-widest animate-pulse">Plus que {{ $type->remaining_quantity }}!</span>
                                                                    @endif
                                                                </div>
                                                                
                                                                @if($type->description)
                                                                    <p class="text-[10px] text-slate-400 font-medium leading-relaxed mb-3 pr-6 uppercase tracking-tight">{{ $type->description }}</p>
                                                                @endif

                                                                <div class="flex items-center gap-2">
                                                                    <span class="text-coral-600 font-black text-sm">{{ number_format($type->price, 0, ',', ' ') }} CFA</span>
                                                                    <span class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">/ ticket</span>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center transition-all mt-1"
                                                                :class="ticketTypeId == {{ $type->id }} ? 'border-coral-600 bg-coral-600' : 'border-slate-200'">
                                                                <div class="w-2 h-2 rounded-full bg-white transition-all transform scale-0"
                                                                    :class="ticketTypeId == {{ $type->id }} ? 'scale-100' : 'scale-0'"></div>
                                                            </div>
                                                        </div>

                                                        @if($type->remaining_quantity <= 0)
                                                            <div class="absolute inset-0 bg-slate-50/80 backdrop-blur-[1px] rounded-3xl flex items-center justify-center z-20 cursor-not-allowed">
                                                                <div class="px-4 py-2 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl shadow-xl">Épuisé</div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div>
                                            <x-input-label value="Nombre de places" />
                                            <div
                                                class="flex items-center justify-between p-2 bg-slate-50 rounded-2xl border border-slate-100">
                                                <button type="button" @click="if(count > 1) count--"
                                                    class="w-10 h-10 bg-white rounded-xl shadow-sm text-slate-900 font-black hover:bg-coral-50 hover:text-coral-600 transition flex items-center justify-center">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2.5" d="M20 12H4"></path>
                                                    </svg>
                                                </button>
                                                <input type="hidden" name="tickets_count" x-model="count">
                                                <span class="text-xl font-black text-slate-900 font-outfit"
                                                    x-text="count"></span>
                                                <button type="button" @click="if(count < 5) count++"
                                                    class="w-10 h-10 bg-white rounded-xl shadow-sm text-slate-900 font-black hover:bg-coral-50 hover:text-coral-600 transition flex items-center justify-center">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="pt-2">
                                            <p
                                                class="text-xs text-slate-400 font-bold uppercase tracking-widest text-center mb-4">
                                                Prix Total</p>
                                            <div class="flex items-baseline justify-center gap-2">
                                                <span class="text-4xl font-black text-slate-950 font-outfit"
                                                    x-text="(count * selectedPrice).toLocaleString()"></span>
                                                <span class="text-lg font-bold text-coral-600">CFA</span>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" 
                                        :disabled="loading"
                                        class="w-full py-5 bg-slate-950 text-white rounded-3xl text-base font-extrabold shadow-coral shadow-xl transform active:scale-95 hover:bg-coral-600 transition-all duration-300 disabled:opacity-70 disabled:cursor-not-allowed flex items-center justify-center gap-3">
                                        <template x-if="!loading">
                                            <span>{{ __('Réserver maintenant') }}</span>
                                        </template>
                                        <template x-if="loading">
                                            <div class="flex items-center gap-2">
                                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                <span>Traitement...</span>
                                            </div>
                                        </template>
                                    </button>
                                </form>
                            </div>

                            <div
                                class="bg-slate-950 p-6 flex items-center justify-between group cursor-pointer overflow-hidden relative rounded-4xl">
                                <div
                                        class="absolute inset-0 bg-coral-600 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                </div>
                                <div class="relative z-10 flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center text-white">
                                        <svg class="w-5 h-5 text-emerald-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.025 3.128l-.9 3.287 3.371-.883a5.742 5.742 0 002.272.484h.001c3.185 0 5.767-2.585 5.768-5.766.001-3.18-2.583-5.766-5.869-5.766zm3.377 8.216c-.147.414-.734.786-1.125.86-.33.064-.766.115-1.22-.057-.457-.174-1.045-.373-1.638-.802-1.218-.879-2.012-2.164-2.128-2.316-.117-.152-.942-1.246-.942-2.376 0-1.13.585-1.685.797-1.914.212-.23.468-.287.625-.287.158 0 .316.004.453.012.142.008.334-.054.524.402.197.473.676 1.643.734 1.761.059.117.098.254.02.41-.078.157-.117.254-.234.39-.118.137-.245.306-.352.41-.122.118-.25.247-.107.493.143.245.635 1.047 1.362 1.696.938.835 1.728 1.093 1.973 1.215.245.123.388.103.53-.064.143-.167.61-.715.773-.956.163-.243.327-.204.551-.122.225.083 1.428.675 1.674.797.245.122.408.184.468.287.06.103.06.6-.087 1.014z">
                                            </path>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-bold text-white">Partager sur WhatsApp</span>
                                </div>
                                <svg class="w-5 h-5 text-white/50 relative z-10 group-hover:translate-x-1 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Safety/Policy Info -->
                        <div class="p-6 bg-white/80 backdrop-blur-sm rounded-4xl border border-white/40 animate-fade-up delay-200">
                            <div class="flex gap-4">
                                <div
                                    class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-coral-600 flex-shrink-0 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                        </path>
                                    </svg>
                                </div>
                                <p class="text-xs text-slate-500 font-medium">Billet électronique envoyé par email
                                    immédiatement après confirmation. Paiement sécurisé et vérifié.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>