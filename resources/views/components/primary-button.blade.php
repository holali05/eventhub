<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-iris-600 border border-transparent rounded-xl font-bold text-sm text-white hover:bg-iris-700 active:bg-iris-800 focus:outline-none focus:ring-2 focus:ring-iris-500 focus:ring-offset-2 shadow-lg shadow-iris-200 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>