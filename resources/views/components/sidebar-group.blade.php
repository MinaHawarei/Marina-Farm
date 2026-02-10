@props(['active' => false, 'title', 'icon', 'count' => 0])

<div x-data="{ open: {{ $active ? 'true' : 'false' }} }" class="relative">
    {{-- Group Header --}}
    <button @click="open = !open" 
            data-tooltip="{{ $title }}"
            class="sidebar-group-header"
            :class="{ 'open': open }">
        <div class="flex items-center">
            <i class="{{ $icon }} sidebar-item-icon"></i>
            <span class="sidebar-text font-medium font-tajawal text-base">{{ $title }}</span>
        </div>
        <div class="flex items-center">
            @if($count > 0)
                <span class="sidebar-badge bg-brand-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full ml-2 shadow-sm">{{ $count }}</span>
            @endif
            <i class="sidebar-chevron fas fa-chevron-down text-xs transition-transform duration-300" :class="{ 'rotate-180': open }"></i>
        </div>
    </button>
    
    {{-- Group Content - Collapsible --}}
    <div x-show="open" 
         x-collapse
         class="sidebar-group-content">
        {{ $slot }}
    </div>
</div>
