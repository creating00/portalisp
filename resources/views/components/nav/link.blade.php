@props(['href' => '#', 'active' => false])

<a href="{{ $href }}" wire:navigate
    {{ $attributes->class([
        'text-sm transition-all duration-300 transform hover:-translate-y-0.5 hover:scale-105 inline-block',
        'text-primary-orange font-bold' => $active,
        'text-white hover:text-primary-orange font-semibold' => !$active,
    ]) }}>
    {{ $slot }}
</a>
