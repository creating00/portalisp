@props([
    'href',
    'variant' => 'default', // default | subtle
])

@php
    $variants = [
        'default' => 'text-gray-400 hover:text-white',
        'subtle' => 'text-gray-500 hover:text-gray-300',
    ];
@endphp

<a href="{{ $href }}" wire:navigate
    class="group inline-flex items-center gap-2 text-sm font-medium transition-all duration-200
           {{ $variants[$variant] }}">
    <span
        class="material-symbols-outlined text-base transition-transform duration-200
               group-hover:-translate-x-1">
        arrow_back
    </span>

    <span class="relative">
        {{ $slot ?? 'Volver' }}
        <span
            class="absolute -bottom-0.5 left-0 h-px w-0 bg-current transition-all duration-200
                   group-hover:w-full"></span>
    </span>
</a>
