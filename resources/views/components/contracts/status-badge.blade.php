@props(['status'])

@php
    $status = strtolower($status ?? 'inactivo');
    $config = match ($status) {
        // Estados de Contrato
        'activo' => ['color' => 'bg-green-500/10 text-green-400 border-green-500/20', 'icon' => 'check_circle'],
        'suspendido' => ['color' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20', 'icon' => 'pause_circle'],
        'baja' => ['color' => 'bg-red-500/10 text-red-400 border-red-500/20', 'icon' => 'cancel'],
        // Estados de Factura (Nuevos)
        'pagado' => ['color' => 'bg-emerald-500/15 text-emerald-400 border-emerald-500/30', 'icon' => 'verified'],
        'pendiente' => ['color' => 'bg-orange-500/15 text-orange-400 border-orange-500/30', 'icon' => 'schedule'],

        default => ['color' => 'bg-gray-500/10 text-gray-400 border-gray-500/20', 'icon' => 'help_outline'],
    };
@endphp

<span
    {{ $attributes->merge(['class' => "inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border shadow-sm backdrop-blur-sm {$config['color']}"]) }}>
    <span class="material-symbols-outlined text-[16px] mr-1.5">{{ $config['icon'] }}</span>
    {{ ucfirst($status) }}
</span>
