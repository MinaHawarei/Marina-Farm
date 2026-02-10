@props(['active' => false, 'href' => '#', 'icon' => null, 'count' => 0])

<a href="{{ $href }}" 
   {{ $attributes->merge(['class' => 'sidebar-sublink' . ($active ? ' active' : '')]) }}>
    <div class="flex items-center">
        @if($icon)
            <i class="{{ $icon }} w-5 text-center ml-2 text-sm opacity-80"></i>
        @endif
        <span class="sidebar-text text-sm font-tajawal">{{ $slot }}</span>
    </div>
    @if($count > 0)
        <span class="sidebar-badge text-[10px] bg-gray-700 text-gray-300 px-1.5 py-0.5 rounded">{{ $count }}</span>
    @endif
</a>
