@props(['type' => 'success', 'timeout' => 5000])

@php
    $styles = [
        'success' => 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400',
        'error' => 'bg-red-500/10 border-red-500/20 text-red-400',
    ];
@endphp

<div x-data="{ show: true }" x-init="setTimeout(() => show = false, {{ $timeout }})" x-show="show" x-transition.opacity.duration.500ms
    class="p-4 rounded-xl border text-sm {{ $styles[$type] }}">
    {{ $slot }}
</div>
