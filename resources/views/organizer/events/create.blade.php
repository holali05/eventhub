<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 font-outfit tracking-tight">Nouvel <span
                        class="text-iris-600">Événement</span></h2>
                <p class="text-slate-500 font-medium mt-1">Créez une expérience mémorable en quelques minutes.</p>
            </div>

            <!-- Breadcrumbs or Stepper Progress for Desktop -->
            <div
                class="hidden md:flex items-center gap-2 bg-white/50 backdrop-blur-sm p-1.5 rounded-2xl border border-white/40 shadow-sm">
                <div
                    class="flex items-center gap-2 px-4 py-2 rounded-xl bg-iris-600 text-white shadow-lg shadow-iris-100">
                    <span
                        class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center text-xs font-bold">1</span>
                    <span class="text-sm font-bold">Informations</span>
                </div>
                <div class="w-8 h-px bg-slate-200"></div>
                <div class="flex items-center gap-2 px-4 py-2 rounded-xl text-slate-400">
                    <span
                        class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold">2</span>
                    <span class="text-sm font-bold">Billetterie</span>
                </div>
                <div class="w-8 h-px bg-slate-200"></div>
                <div class="flex items-center gap-2 px-4 py-2 rounded-xl text-slate-400">
                    <span
                        class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold">3</span>
                    <span class="text-sm font-bold">Promotion</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6" x-data="{ 
        step: 1, 
        tickets: [{ name: '', price: '', total_quantity: '' }],
        addTicket() {
            this.tickets.push({ name: '', price: '', total_quantity: '' });
        },
        removeTicket(index) {
            this.tickets.splice(index, 1);
        },
        setPreset(index, name) {
            this.tickets[index].name = name;
            if (name === 'GRATUIT') {
                this.tickets[index].price = 0;
            }
        }
    }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Mobile Step Indicator -->
            <div class="md:hidden mb-8 flex items-center justify-between px-2">
                <template x-for="i in [1, 2, 3]">
                    <div class="flex flex-col items-center gap-2">
                        <div :class="step >= i ? 'bg-iris-600 text-white' : 'bg-white text-slate-300 border border-slate-100'"
                            class="w-10 h-10 rounded-2xl flex items-center justify-center font-bold transition-all shadow-sm">
                            <span x-text="i"></span>
                        </div>
                        <span :class="step >= i ? 'text-iris-600 font-bold' : 'text-slate-400 font-medium'"
                            class="text-[10px] uppercase tracking-widest"
                            x-text="i == 1 ? 'Infos' : (i == 2 ? 'Boutique' : 'Pub')"></span>
                    </div>
                </template>
            </div>

            <form action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- STEP 1: GENERAL INFOS -->
                <div x-show="step === 1" x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="bg-white rounded-4xl shadow-soft border border-white/40 p-8 sm:p-12">
                        <div class="mb-10">
                            <h3 class="text-2xl font-bold text-slate-900 font-outfit flex items-center gap-3">
                                <span
                                    class="w-10 h-10 rounded-2xl bg-iris-50 text-iris-600 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </span>
                                Informations Générales
                            </h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="md:col-span-2">
                                <x-input-label for="title" value="Titre de l'événement" />
                                <x-text-input id="title" name="title" type="text" class="w-full"
                                    placeholder="Ex: Grand Gala Annuel 2026" required />
                            </div>

                            <div>
                                <x-input-label for="event_date" value="Date de l'événement" />
                                <x-text-input id="event_date" name="event_date" type="date" class="w-full" required />
                            </div>

                            <div>
                                <x-input-label for="event_time" value="Heure de début" />
                                <x-text-input id="event_time" name="event_time" type="time" class="w-full" required />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="location" value="Lieu" />
                                <x-text-input id="location" name="location" type="text" class="w-full"
                                    placeholder="Ex: Palais des Congrès, Paris" required />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="description" value="Description" />
                                <textarea id="description" name="description" rows="4"
                                    class="w-full border-slate-200 focus:border-iris-500 focus:ring-iris-500 rounded-2xl shadow-sm text-slate-700 placeholder:text-slate-400"
                                    placeholder="Décrivez votre événement en quelques lignes..."></textarea>
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label value="Photo de couverture" />
                                <div
                                    class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-3xl hover:border-iris-300 transition-colors group bg-slate-50/50">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-slate-300 group-hover:text-iris-400 transition-colors"
                                            stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-slate-600">
                                            <label for="image"
                                                class="relative cursor-pointer bg-transparent rounded-md font-bold text-iris-600 hover:text-iris-500 focus-within:outline-none">
                                                <span>Télécharger un fichier</span>
                                                <input id="image" name="image" type="file" class="sr-only" required
                                                    accept="image/*">
                                            </label>
                                            <p class="pl-1">ou glisser-déposer</p>
                                        </div>
                                        <p class="text-xs text-slate-400 italic">PNG, JPG, GIF jusqu'à 10MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-12 flex justify-end">
                            <button type="button" @click="step = 2"
                                class="px-8 py-4 bg-iris-600 text-white rounded-2xl font-bold shadow-lg shadow-iris-200 hover:bg-iris-700 transform hover:-translate-y-1 transition items-center flex gap-2">
                                Étape suivante: Billetterie
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- STEP 2: TICKETS -->
                <div x-show="step === 2" x-cloak x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div
                        class="bg-white rounded-[50px] shadow-soft border border-white/40 p-10 sm:p-16 relative overflow-hidden">
                        <div
                            class="absolute top-0 right-0 -mr-24 -mt-24 w-96 h-96 bg-iris-50 rounded-full blur-3xl opacity-40">
                        </div>

                        <div class="relative z-10">
                            <div class="mb-14 flex flex-col md:flex-row md:items-end justify-between gap-8">
                                <div>
                                    <div
                                        class="inline-flex items-center gap-2 px-4 py-1.5 bg-iris-100 text-iris-700 text-[11px] font-black uppercase tracking-widest rounded-xl mb-6 shadow-sm shadow-iris-100/20">
                                        Multi-Ticketing Intelligent
                                    </div>
                                    <h3
                                        class="text-4xl font-extrabold text-slate-900 font-outfit leading-tight lg:text-5xl tracking-tighter">
                                        Créez vos <span class="text-iris-600">Offres</span></h3>
                                    <p class="text-slate-500 font-medium mt-4 max-w-lg leading-relaxed text-lg">VIP,
                                        Standard ou Gratuit ? Ajoutez autant de catégories que vous le souhaitez pour le
                                        même évènement.</p>
                                </div>
                                <button type="button" @click="addTicket()"
                                    class="inline-flex items-center gap-4 px-10 py-6 bg-slate-950 text-white rounded-[30px] font-black text-xs hover:bg-iris-600 transition shadow-2xl shadow-slate-200 transform active:scale-95 group border-2 border-slate-900 hover:border-iris-600 uppercase tracking-widest leading-none">
                                    <div
                                        class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center group-hover:rotate-90 transition-transform duration-500 ring-2 ring-white/10 shadow-inner">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </div>
                                    AJOUTER UNE NOUVELLE CATÉGORIE
                                </button>
                            </div>

                            <div class="space-y-12">
                                <template x-for="(ticket, index) in tickets" :key="index">
                                    <div
                                        class="relative group bg-slate-50 border-2 border-dashed border-slate-200 p-10 rounded-[45px] hover:border-iris-300 hover:bg-white transition-all duration-500 shadow-sm">
                                        <div
                                            class="flex items-center justify-between mb-10 pb-8 border-b border-slate-100/80">
                                            <div class="flex items-center gap-5">
                                                <div
                                                    class="w-16 h-16 rounded-[22px] bg-slate-950 text-white flex items-center justify-center text-2xl font-black font-outfit shadow-2xl shadow-slate-200 relative overflow-hidden group/num">
                                                    <div
                                                        class="absolute inset-0 bg-iris-600 opacity-0 group-hover/num:opacity-20 transition-opacity">
                                                    </div>
                                                    <span class="relative" x-text="index + 1"></span>
                                                </div>
                                                <div>
                                                    <h4 class="text-2xl font-black text-slate-900 font-outfit tracking-tighter"
                                                        x-text="ticket.name || 'Offre sans nom'"></h4>
                                                    <p
                                                        class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                                        Détails & Avantages</p>
                                                </div>
                                            </div>

                                            <button type="button" x-show="tickets.length > 1"
                                                @click="removeTicket(index)"
                                                class="w-14 h-14 bg-white text-rose-500 rounded-2xl flex items-center justify-center border border-slate-100 shadow-xl shadow-slate-100/50 hover:bg-rose-50 hover:text-rose-600 transition transform hover:rotate-12 group/del">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2.5"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                                            <div class="lg:col-span-12 grid grid-cols-1 md:grid-cols-3 gap-8">
                                                <div class="md:col-span-1">
                                                    <x-input-label value="Nom du Ticket / Offre" />
                                                    <div class="mt-3 space-y-5">
                                                        <x-text-input x-model="ticket.name"
                                                            ::name="`tickets[${index}][name]`" type="text"
                                                            class="w-full bg-white border-slate-100 !rounded-2xl"
                                                            placeholder="EX: PASS VIP GOLD" required />
                                                        <div class="flex flex-wrap gap-2">
                                                            <template x-for="preset in ['STANDARD', 'VIP', 'GRATUIT']">
                                                                <button type="button" @click="setPreset(index, preset)"
                                                                    class="px-3 py-2 bg-white text-slate-400 text-[10px] font-black rounded-xl border border-slate-100 hover:bg-iris-50 hover:text-iris-600 hover:border-iris-200 transition shadow-sm uppercase tracking-tighter"
                                                                    x-text="preset"></button>
                                                            </template>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <x-input-label value="Tarif (CFA)" />
                                                    <div class="relative mt-3">
                                                        <div
                                                            class="absolute inset-y-0 left-5 flex items-center pointer-events-none text-slate-300 font-black text-sm">
                                                            CFA</div>
                                                        <x-text-input x-model="ticket.price"
                                                            ::name="`tickets[${index}][price]`" type="number"
                                                            class="w-full pl-16 bg-white border-slate-100 !rounded-2xl disabled:bg-slate-100 disabled:text-slate-400"
                                                            placeholder="5000" min="0" required
                                                            ::disabled="ticket.name === 'GRATUIT'" />
                                                    </div>
                                                </div>

                                                <div>
                                                    <x-input-label value="Quota de billets" />
                                                    <div class="relative mt-3">
                                                        <div
                                                            class="absolute inset-y-0 left-5 flex items-center pointer-events-none text-slate-300">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2.5"
                                                                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                                                                </path>
                                                            </svg>
                                                        </div>
                                                        <x-text-input ::name="`tickets[${index}][total_quantity]`"
                                                            type="number"
                                                            class="w-full pl-14 bg-white border-slate-100 !rounded-2xl"
                                                            placeholder="100" min="1" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="lg:col-span-12">
                                                <x-input-label value="Description de l'offre & Avantages" />
                                                <div class="mt-3">
                                                    <textarea ::name="`tickets[${index}][description]`" rows="2"
                                                        class="w-full border-slate-100 focus:border-iris-500 focus:ring-iris-500 rounded-[25px] shadow-sm bg-white placeholder:text-slate-200 text-sm font-bold text-slate-600"
                                                        placeholder="EX: Accès prioritaire, cocktail de bienvenue, placement réservé..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div
                                class="mt-16 p-12 bg-slate-900 rounded-[55px] text-white relative overflow-hidden group shadow-2xl shadow-slate-200">
                                <div
                                    class="absolute top-0 right-0 p-12 opacity-5 group-hover:opacity-15 transition-all duration-700 rotate-12 group-hover:scale-110">
                                    <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm4.59-12.42L10 14.17l-2.59-2.58L6 13l4 4 8-8z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                                    <div>
                                        <div
                                            class="inline-flex items-center gap-3 px-4 py-1.5 bg-white/5 text-iris-400 text-[11px] font-black uppercase tracking-widest rounded-xl mb-8 border border-white/10 shadow-inner">
                                            Logistique Finale
                                        </div>
                                        <h4 class="text-4xl font-extrabold font-outfit mb-4 leading-tight">Validation
                                            <span class="text-iris-400">Générale</span>
                                        </h4>
                                        <p class="text-slate-400 text-lg font-medium leading-relaxed max-w-md">Vérifiez
                                            la capacité totale accueillable et téléchargez le design qui sera imprimé
                                            sur les billets.</p>
                                    </div>
                                    <div class="space-y-8">
                                        <div class="relative group/input">
                                            <div
                                                class="absolute left-6 top-1/2 -translate-y-1/2 w-10 h-10 rounded-2xl bg-white/5 flex items-center justify-center text-white/30 group-focus-within/input:text-iris-400 transition-colors border border-white/5 shadow-inner">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2.5"
                                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <x-text-input name="capacity" type="number"
                                                class="w-full bg-white/5 border-white/10 text-white placeholder:text-white/20 pl-20 py-6 !rounded-[30px] focus:bg-white/10 transition-all font-black text-xl"
                                                placeholder="Capacité totale attendue" required />
                                        </div>
                                        <div class="relative group/input">
                                            <label
                                                class="flex items-center justify-between px-8 py-6 bg-white/5 border border-white/10 rounded-[30px] cursor-pointer hover:bg-white/10 transition-all group-hover/input:border-iris-500/50 shadow-inner">
                                                <div class="flex items-center gap-5">
                                                    <div
                                                        class="w-12 h-12 rounded-2xl bg-iris-500/20 text-iris-400 flex items-center justify-center shadow-lg shadow-iris-500/10 border border-iris-500/20">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2.5"
                                                                d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                    <div class="flex flex-col">
                                                        <span
                                                            class="text-xs font-black text-white uppercase tracking-widest leading-none mb-1">Design
                                                            du Billet</span>
                                                        <span
                                                            class="text-[10px] font-bold text-white/30 uppercase tracking-tight">Format
                                                            Image Requis</span>
                                                    </div>
                                                </div>
                                                <input type="file" name="ticket_template" required accept="image/*"
                                                    class="sr-only">
                                                <div
                                                    class="px-5 py-2.5 bg-iris-600 text-white rounded-2xl text-[10px] font-black border border-iris-500 shadow-xl shadow-iris-600/20 hover:scale-105 transition-transform">
                                                    TELECHARGER</div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="mt-16 flex flex-col md:flex-row justify-between items-center pt-10 border-t border-slate-100/80 gap-6">
                                <button type="button" @click="step = 1"
                                    class="group flex items-center gap-4 px-8 py-5 text-slate-400 font-black text-xs uppercase tracking-[0.2em] hover:text-slate-900 transition mt-4 rounded-[25px] hover:bg-slate-50">
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center group-hover:bg-white border border-transparent group-hover:border-slate-100 group-hover:-translate-x-2 transition-all shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M10 19l-7-7m0 0l-7-7m7-7H21"></path>
                                        </svg>
                                    </div>
                                    Retour
                                </button>
                                <button type="button" @click="step = 3"
                                    class="inline-flex items-center gap-5 px-14 py-6 bg-iris-600 text-white rounded-[35px] font-black shadow-[0_25px_50px_-12px_rgba(99,102,241,0.4)] hover:shadow-[0_25px_50px_-12px_rgba(99,102,241,0.6)] hover:bg-iris-700 transform hover:-translate-y-2 transition-all text-xs uppercase tracking-[0.3em] leading-none active:scale-95 group/btn">
                                    Finaliser & Publier
                                    <div
                                        class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center group-hover/btn:translate-x-2 transition-transform shadow-inner border border-white/10">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 3: PROMOTION & SUBMIT -->
                <div x-show="step === 3" x-cloak x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="bg-white rounded-4xl shadow-soft border border-white/40 p-8 sm:p-12">
                        <div class="mb-10">
                            <h3 class="text-2xl font-bold text-slate-900 font-outfit flex items-center gap-3">
                                <span
                                    class="w-10 h-10 rounded-2xl bg-iris-50 text-iris-600 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.167M11 5.882c.499-.058 1.012-.088 1.536-.088 2.31 0 4.438.546 6.315 1.528M11 5.882a15.668 15.668 0 011.536-1.118m2.147-6.167a1.76 1.76 0 003.417.592l2.147 6.167m-6.711-6.167a1.76 1.76 0 01-3.417-.592l-2.147-6.167">
                                        </path>
                                    </svg>
                                </span>
                                Promotion & Lancement
                            </h3>
                        </div>

                        <div class="p-8 bg-emerald-50 rounded-4xl border border-emerald-100 mb-10 text-center">
                            <div
                                class="w-20 h-20 bg-emerald-500 text-white rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-emerald-200">
                                <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.025 3.128l-.9 3.287 3.371-.883a5.742 5.742 0 002.272.484h.001c3.185 0 5.767-2.585 5.768-5.766.001-3.18-2.583-5.766-5.869-5.766zm3.377 8.216c-.147.414-.734.786-1.125.86-.33.064-.766.115-1.22-.057-.457-.174-1.045-.373-1.638-.802-1.218-.879-2.012-2.164-2.128-2.316-.117-.152-.942-1.246-.942-2.376 0-1.13.585-1.685.797-1.914.212-.23.468-.287.625-.287.158 0 .316.004.453.012.142.008.334-.054.524.402.197.473.676 1.643.734 1.761.059.117.098.254.02.41-.078.157-.117.254-.234.39-.118.137-.245.306-.352.41-.122.118-.25.247-.107.493.143.245.635 1.047 1.362 1.696.938.835 1.728 1.093 1.973 1.215.245.123.388.103.53-.064.143-.167.61-.715.773-.956.163-.243.327-.204.551-.122.225.083 1.428.675 1.674.797.245.122.408.184.468.287.06.103.06.6-.087 1.014z">
                                    </path>
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-emerald-900 mb-2">Importez votre liste WhatsApp</h4>
                            <p class="text-slate-600 mb-8 max-w-sm mx-auto">Préparez le terrain en important vos
                                contacts. Ils pourront être notifiés par la suite.</p>

                            <div class="max-w-xs mx-auto">
                                <label class="block mb-4">
                                    <span class="sr-only">Fichier CSV</span>
                                    <input type="file" name="whatsapp_file" accept=".csv"
                                        class="block w-full text-sm text-emerald-600 file:mr-4 file:py-3 file:px-4 file:rounded-2xl file:border-0 file:text-sm file:font-bold file:bg-emerald-100 file:text-emerald-700 hover:file:bg-emerald-200 cursor-pointer">
                                </label>
                            </div>
                        </div>

                        <div class="bg-iris-950 rounded-4xl p-8 text-white relative overflow-hidden">
                            <div class="absolute top-0 right-0 p-8 opacity-10">
                                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z">
                                    </path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold mb-4">Presque terminé...</h4>
                            <p class="text-iris-200 text-sm mb-8 leading-relaxed">Vérifiez bien vos informations avant
                                de cliquer sur le bouton ci-dessous. Votre événement sera soumis à l'approbation de
                                l'administrateur avant d'être publié.</p>

                            <div class="flex flex-col sm:flex-row gap-4">
                                <button type="submit"
                                    class="flex-grow px-8 py-4 bg-iris-600 text-white rounded-2xl font-bold shadow-xl shadow-iris-400/20 hover:bg-iris-500 transform hover:-translate-y-1 transition text-center">
                                    🚀 Publier l'événement
                                </button>
                                <button type="button" @click="step = 2"
                                    class="px-8 py-4 bg-white/10 text-white rounded-2xl font-bold hover:bg-white/20 transition text-center whitespace-nowrap">
                                    Modifier
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }

        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 10s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }
    </style>
</x-app-layout>