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
        href="data:image/svg+xml,<svg viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'><circle cx='50' cy='50' r='45' fill='none' stroke='%236366f1' stroke-width='2' opacity='0.2' /><path d='M35 25C30 25 25 30 25 35V65C25 70 30 75 35 75H65' stroke='darkslategray' stroke-width='8' fill='none' stroke-linecap='round' /><path d='M45 40L65 50L45 60' fill='%236366f1' /><circle cx='65' cy='50' r='6' fill='%236366f1' /></svg>">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body class="font-sans text-slate-900 antialiased selection:bg-coral-100 selection:text-coral-700">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden">
        <!-- Decorative blobs -->
        <div
            class="absolute -top-16 -left-16 w-80 h-80 bg-coral-300 rounded-full mix-blend-multiply filter blur-3xl opacity-35 animate-blob pointer-events-none">
        </div>
        <div
            class="absolute top-10 -right-16 w-80 h-80 bg-amber-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000 pointer-events-none">
        </div>
        <div
            class="absolute -bottom-16 left-1/4 w-72 h-72 bg-rose-300 rounded-full mix-blend-multiply filter blur-3xl opacity-25 animate-blob animation-delay-4000 pointer-events-none">
        </div>

        <div class="z-10 w-full flex flex-col items-center">
            <a href="/" class="mb-8 flex flex-col items-center gap-4 group">
                <x-application-logo class="w-16 h-16 transition-transform duration-300 group-hover:scale-110" />
                <span
                    class="text-4xl font-extrabold tracking-tight text-iris-600 font-outfit group-hover:text-iris-700 transition-colors">Event<span
                        class="text-slate-900">Hub</span></span>
            </a>


            <div
                class="w-full sm:max-w-md px-8 py-10 bg-white shadow-soft sm:rounded-4xl border border-white/40 backdrop-blur-sm z-10">
                {{ $slot }}
            </div>

            <p class="mt-8 text-sm text-slate-500 font-medium">
                &copy; {{ date('Y') }} EventHub. Tous droits réservés.
            </p>
        </div>
    </div>
    {{-- Animations now in resources/css/app.css --}}
</body>

</html>