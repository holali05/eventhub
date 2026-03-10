<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EventHub') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,<svg viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'><circle cx='50' cy='50' r='45' fill='none' stroke='%23ed3314' stroke-width='2' opacity='0.2' /><path d='M35 25C30 25 25 30 25 35V65C25 70 30 75 35 75H65' stroke='darkslategray' stroke-width='8' fill='none' stroke-linecap='round' /><path d='M45 40L65 50L45 60' fill='%23ed3314' /><circle cx='65' cy='50' r='6' fill='%23ed3314' /></svg>">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body class="font-sans text-slate-900 antialiased selection:bg-coral-100 selection:text-coral-700">
    <div class="min-h-screen relative overflow-hidden">
        <!-- Decorative blobs -->
        <div
            class="absolute -top-20 -left-20 w-[500px] h-[500px] bg-coral-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob pointer-events-none">
        </div>
        <div
            class="absolute top-1/3 -right-20 w-[450px] h-[450px] bg-amber-300 rounded-full mix-blend-multiply filter blur-3xl opacity-25 animate-blob animation-delay-2000 pointer-events-none">
        </div>
        <div
            class="absolute bottom-0 left-1/3 w-[400px] h-[400px] bg-rose-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000 pointer-events-none">
        </div>

        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="py-10 relative z-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="relative z-10 pb-20">
            {{ $slot }}
        </main>

        <!-- Global Toast System -->
        <div x-data="{ 
            notifications: [],
            add(msg, type = 'info') {
                const id = Date.now();
                this.notifications.push({ id, msg, type });
                setTimeout(() => this.remove(id), 5000);
            },
            remove(id) {
                this.notifications = this.notifications.filter(n => n.id !== id);
            }
        }" @notify.window="add($event.detail.message, $event.detail.type)"
            class="fixed bottom-10 right-10 z-[100] flex flex-col gap-3 max-w-sm w-full">

            @if(session('success'))
                <div x-init="add('{{ session('success') }}', 'success')" class="hidden"></div>
            @endif
            @if(session('error'))
                <div x-init="add('{{ session('error') }}', 'error')" class="hidden"></div>
            @endif

            <template x-for="n in notifications" :key="n.id">
                <div x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="translate-x-full opacity-0"
                    x-transition:enter-end="translate-x-0 opacity-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="translate-x-0 opacity-100"
                    x-transition:leave-end="translate-x-full opacity-0"
                    class="bg-white rounded-2xl shadow-2xl p-4 border border-slate-100 flex items-center gap-4 group">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" :class="{
                            'bg-emerald-50 text-emerald-500': n.type === 'success',
                            'bg-rose-50 text-rose-500': n.type === 'error',
                            'bg-coral-50 text-coral-500': n.type === 'info'
                         }">
                        <template x-if="n.type === 'success'">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </template>
                        <template x-if="n.type === 'error'">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                        </template>
                    </div>
                    <div class="flex-1">
                        <p class="text-[11px] font-black uppercase tracking-widest text-slate-400 mb-0.5"
                            x-text="n.type"></p>
                        <p class="text-sm font-bold text-slate-900 leading-tight" x-text="n.msg"></p>
                    </div>
                    <button @click="remove(n.id)" class="text-slate-300 hover:text-slate-500 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </template>
        </div>
    </div>

    {{-- Animations now in resources/css/app.css --}}
</body>

</html>