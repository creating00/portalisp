@props(['href' => '#', 'icon' => 'east', 'special' => false])

<a href="{{ $href }}" wire:navigate
    {{ $attributes->merge([
        'class' =>
            'group flex items-center justify-between px-4 py-3 text-sm rounded-xl transition-all duration-300 relative overflow-hidden ' .
            ($special
                ? 'text-primary-orange hover:bg-primary-orange/10 font-bold'
                : 'text-slate-300 hover:text-white hover:bg-white/5'),
    ]) }}>

    {{-- Efecto de brillo al pasar el mouse (opcional) --}}
    <div
        class="absolute inset-0 opacity-0 group-hover:opacity-100 bg-gradient-to-r from-transparent via-white/[0.03] to-transparent transition-opacity duration-500">
    </div>

    <span class="relative z-10">{{ $slot }}</span>

    <span @class([
        'material-symbols-outlined transition-all duration-500 text-sm relative z-10',
        'opacity-0 -translate-x-4 group-hover:opacity-100 group-hover:translate-x-0',
        'text-primary-violet' => !$special,
        'text-primary-orange' => $special,
    ])>
        {{ $icon }}
    </span>
</a>
