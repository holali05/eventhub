@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'block w-full ps-4 pe-4 py-2.5 border-l-4 border-coral-500 text-start text-sm font-bold text-coral-700 bg-coral-50 rounded-r-xl focus:outline-none transition duration-150 ease-in-out'
        : 'block w-full ps-4 pe-4 py-2.5 border-l-4 border-transparent text-start text-sm font-medium text-slate-600 hover:text-coral-600 hover:bg-coral-50/60 hover:border-coral-300 focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>