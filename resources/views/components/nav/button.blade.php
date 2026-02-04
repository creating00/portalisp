@props(['href' => '#'])

<a href="{{ $href }}" wire:navigate
    {{ $attributes->merge(['class' => 'relative group overflow-hidden bg-primary-orange hover:bg-orange-600 text-white px-8 py-2.5 rounded-full font-extrabold text-sm transition-all duration-300 hover:scale-105 hover:shadow-[0_0_25px_rgba(249,115,22,0.5)] active:scale-95 inline-block text-center']) }}>

    {{-- Efecto Shimmer (Brillo que pasa) --}}
    <div
        class="absolute inset-0 w-full h-full transition-all duration-500 -translate-x-full group-hover:translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent">
    </div>

    <span class="relative z-10">
        {{ $slot }}
    </span>
</a>
