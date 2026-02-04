@props(['icon', 'title', 'description', 'color'])

@php
    // Mapeo de clases completas para que Tailwind las detecte
    $theme = match ($color) {
        'primary-violet' => [
            'text' => 'text-primary-violet',
            'bg_light' => 'bg-primary-violet/10',
            'bg_hover' => 'group-hover:bg-primary-violet',
            'border_hover' => 'hover:border-primary-violet/50',
            'shadow_hover' => 'hover:shadow-primary-violet/10',
        ],
        'primary-orange' => [
            'text' => 'text-primary-orange',
            'bg_light' => 'bg-primary-orange/10',
            'bg_hover' => 'group-hover:bg-primary-orange',
            'border_hover' => 'hover:border-primary-orange/50',
            'shadow_hover' => 'hover:shadow-primary-orange/10',
        ],
        default => [
            'text' => 'text-slate-600',
            'bg_light' => 'bg-slate-100',
            'bg_hover' => 'group-hover:bg-slate-900',
            'border_hover' => 'hover:border-slate-300',
            'shadow_hover' => 'hover:shadow-slate-200',
        ],
    };
@endphp

<div
    {{ $attributes->merge([
        'class' =>
            'p-8 rounded-3xl bg-white dark:bg-brand-dark border border-slate-200 dark:border-white/10 transition-all duration-300 group hover:-translate-y-1 hover:shadow-2xl ' .
            $theme['border_hover'] .
            ' ' .
            $theme['shadow_hover'],
    ]) }}>

    {{-- Contenedor del Icono --}}
    <div
        class="w-14 h-14 rounded-2xl flex items-center justify-center mb-6 transition-all duration-300 {{ $theme['bg_light'] }} {{ $theme['text'] }} {{ $theme['bg_hover'] }} group-hover:text-white group-hover:scale-110 group-hover:shadow-lg">
        <span class="material-symbols-outlined text-3xl">{{ $icon }}</span>
    </div>

    {{-- Texto --}}
    <h3 class="text-xl font-bold mb-3 text-slate-900 dark:text-white">
        {{ $title }}
    </h3>
    <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
        {{ $description }}
    </p>
</div>
