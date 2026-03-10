@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-slate-200 focus:border-iris-500 focus:ring-iris-500 rounded-xl shadow-sm text-slate-700 placeholder:text-slate-400']) }}>