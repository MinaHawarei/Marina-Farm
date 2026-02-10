<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-6 py-2.5 bg-white border border-gray-200 rounded-xl font-medium text-sm text-gray-700 font-tajawal shadow-sm hover:bg-gray-50 hover:border-gray-300 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-500/20 active:bg-gray-100 disabled:opacity-50 transition-all duration-200 transform active:scale-95']) }}>
    {{ $slot }}
</button>
