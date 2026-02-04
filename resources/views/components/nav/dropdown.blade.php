@props(['label'])

<div x-data="{ open: false }" class="relative inline-block" @click.away="open = false">
    <button @click="open = !open"
        class="flex max-w-[160px] items-center gap-1.5 text-sm font-semibold
           text-white/90 hover:text-white transition-all duration-300
           outline-none group truncate">
        <span class="truncate">
            {{ $label }}
        </span>

        <span
            class="material-symbols-outlined transition-transform duration-500
               text-[18px] text-primary-violet group-hover:text-primary-orange"
            :class="open ? 'rotate-180' : ''">
            expand_more
        </span>
    </button>

    {{-- Dropdown Menu --}}
    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        class="absolute right-0 mt-4 w-56 rounded-2xl bg-brand-dark/90 backdrop-blur-2xl
            border border-white/10 p-2 shadow-[0_20px_50px_rgba(0,0,0,0.5)]
            z-50 ring-1 ring-white/5"
        style="display: none;">

        {{-- Decoración: Sutil resplandor interno --}}
        <div
            class="absolute inset-0 bg-gradient-to-br from-primary-violet/5 to-transparent rounded-2xl pointer-events-none">
        </div>

        <div class="relative z-10">
            {{ $slot }}
        </div>
    </div>
</div>
