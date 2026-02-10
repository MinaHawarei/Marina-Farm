@props(['active' => false, 'href' => '#', 'icon' => null])

@php
$label = trim($slot->toHtml());
@endphp

<a href="{{ $href }}" 
   data-tooltip="{{ $label }}"
   {{ $attributes->merge(['class' => 'sidebar-item' . ($active ? ' active' : '')]) }}>
    @if($icon)
        <i class="{{ $icon }} sidebar-item-icon"></i>
    @endif
    <span class="sidebar-text font-medium font-tajawal text-base">{{ $slot }}</span>
</a>
