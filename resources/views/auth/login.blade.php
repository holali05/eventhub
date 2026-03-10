<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-extrabold text-slate-900 font-outfit mb-2">Bienvenue!</h2>
        <p class="text-slate-500 font-medium">Connectez-vous pour gérer vos événements.</p>
    </div>

    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Adresse Email')" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" placeholder="votre@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1">
                <x-input-label for="password" :value="__('Mot de passe')" class="mb-0" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-bold text-iris-600 hover:text-iris-700 transition"
                        href="{{ route('password.request') }}">
                        {{ __('Oublié ?') }}
                    </a>
                @endif
            </div>
            <x-text-input id="password" class="block w-full" type="password" name="password" required
                autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox"
                class="w-4 h-4 rounded border-slate-300 text-iris-600 shadow-sm focus:ring-iris-500 focus:ring-offset-0 transition"
                name="remember">
            <span class="ms-2 text-sm text-slate-500 font-medium">{{ __('Se souvenir de moi') }}</span>
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full">
                {{ __('Se connecter') }}
            </x-primary-button>
        </div>

        <div class="text-center pt-4">
            <p class="text-sm text-slate-500 font-medium">
                Vous n'avez pas de compte ?
                <a href="{{ route('register') }}" class="text-iris-600 font-bold hover:text-iris-700 transition">
                    S'inscrire gratuitement
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>