@props(['status'])

@php
    use App\Enums\StatusType;
    $statusEnum = StatusType::tryFrom(strtolower($status)) ?? null;
@endphp

@if ($statusEnum)
    <span
        {{ $attributes->merge(['class' => "inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border shadow-sm backdrop-blur-sm {$statusEnum->colorClasses()}"]) }}>
        <span class="material-symbols-outlined text-[16px] mr-1.5">{{ $statusEnum->icon() }}</span>
        {{ $statusEnum->label() }}
    </span>
@else
    {{-- Fallback por si llega un estado desconocido --}}
    <span
        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border bg-gray-500/10 text-gray-400 border-gray-500/20">
        <span class="material-symbols-outlined text-[16px] mr-1.5">help_outline</span>
        {{ ucfirst($status) }}
    </span>
@endif
