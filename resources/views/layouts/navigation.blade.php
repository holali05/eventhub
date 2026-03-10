<nav x-data="{ open: false }" class="sticky top-4 z-50 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
    <div
        class="bg-white/70 backdrop-blur-xl border border-white/40 shadow-soft rounded-3xl h-16 sm:h-20 flex items-center justify-between px-6 sm:px-10">
        <div class="flex items-center">
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="group flex items-center gap-3">
                    <x-application-logo class="w-10 h-10 transition-transform duration-200 group-hover:scale-110" />
                    <span
                        class="text-2xl font-extrabold tracking-tight text-coral-600 font-outfit transition-colors duration-200 inline-block">Event<span
                            class="text-slate-900">Hub</span></span>
                </a>
            </div>


            <!-- Navigation Links -->
            @auth
                <div class="hidden space-x-1 sm:ms-12 sm:flex items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="px-4 py-2">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')"
                            class="px-4 py-2">
                            {{ __('Comptes') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.events.index')" :active="request()->routeIs('admin.events.index')"
                            class="px-4 py-2">
                            {{ __('Événements') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->role === 'organizer')
                        <x-nav-link :href="route('organizer.events.index')" :active="request()->routeIs('organizer.events.*')"
                            class="px-4 py-2">
                            {{ __('Mes Événements') }}
                        </x-nav-link>
                    @endif
                </div>
            @else
                <div class="hidden space-x-1 sm:ms-12 sm:flex items-center text-sm font-bold text-slate-500">
                    Bienvenue sur EventHub, l'agenda de vos sorties.
                </div>
            @endauth
        </div>

        <div class="hidden sm:flex sm:items-center">
            @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center gap-3 p-1.5 pl-4 rounded-2xl bg-slate-50 border border-slate-100 hover:bg-slate-100 transition-all duration-200 group">
                            <div class="text-right">
                                <p class="text-xs font-bold text-slate-900 leading-none">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] font-black text-coral-600 uppercase tracking-widest mt-1">
                                    {{ Auth::user()->role }}
                                </p>
                            </div>
                            <div
                                class="w-10 h-10 rounded-xl bg-coral-600 flex items-center justify-center text-white font-bold group-hover:rotate-6 transition-transform">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="rounded-t-xl">
                            {{ __('Mon Profil') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="rounded-b-xl text-rose-500">
                                {{ __('Déconnexion') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            @else
                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}"
                        class="text-sm font-bold text-slate-600 hover:text-coral-600 transition">Connexion</a>
                    <a href="{{ route('register') }}"
                        class="px-6 py-2.5 bg-coral-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-coral-100 hover:bg-coral-700 transition">S'inscrire</a>
                </div>
            @endauth
        </div>

        <!-- Hamburger 메뉴 (Mobile) -->
        <div class="-me-2 flex items-center sm:hidden">
            <button @click="open = ! open"
                class="p-2 rounded-xl text-slate-500 hover:text-coral-600 hover:bg-coral-50 transition duration-150">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden mt-2">
        <div class="bg-white/90 backdrop-blur-xl border border-white/40 shadow-xl rounded-3xl p-6 space-y-2">
            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                @if(Auth::user()->role === 'admin')
                    <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                        {{ __('Approuver Comptes') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.events.index')"
                        :active="request()->routeIs('admin.events.index')">
                        {{ __('Gestion Événements') }}
                    </x-responsive-nav-link>
                @endif

                @if(Auth::user()->role === 'organizer')
                    <x-responsive-nav-link :href="route('organizer.events.index')"
                        :active="request()->routeIs('organizer.events.*')">
                        {{ __('Mes Événements') }}
                    </x-responsive-nav-link>
                @endif

                <div class="pt-4 mt-4 border-t border-slate-100">
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="w-10 h-10 rounded-xl bg-coral-600 flex items-center justify-center text-white font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-900">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] font-black text-coral-600 uppercase tracking-widest leading-none mt-1">
                                {{ Auth::user()->role }}
                            </p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center justify-center px-4 py-2 bg-slate-50 text-slate-700 text-xs font-bold rounded-xl border border-slate-100">
                            {{ __('Profil') }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center justify-center px-4 py-2 bg-rose-50 text-rose-600 text-xs font-bold rounded-xl border border-rose-100">
                                {{ __('Sortir') }}
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="space-y-3 pt-2">
                    <a href="{{ route('login') }}"
                        class="block w-full text-center py-3 bg-slate-100 text-slate-700 rounded-2xl font-bold transition">Connexion</a>
                    <a href="{{ route('register') }}"
                        class="block w-full text-center py-3 bg-coral-600 text-white rounded-2xl font-bold shadow-lg shadow-coral-100 transition">S'inscrire</a>
                </div>
            @endauth
        </div>
    </div>
</nav>