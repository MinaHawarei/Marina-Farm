<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-2.5 bg-brand-600 border border-transparent rounded-xl font-medium text-sm text-white font-tajawal shadow-lg shadow-brand-500/20 hover:bg-brand-700 hover:shadow-brand-600/30 focus:bg-brand-700 active:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition-all duration-200 transform active:scale-95']) }}>
    {{ $slot }}
</button>
