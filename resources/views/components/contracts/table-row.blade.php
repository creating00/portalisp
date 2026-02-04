@props(['item'])

<tr class="group hover:bg-white/[0.03] transition-colors">
    <td class="px-6 py-5">
        <div class="flex items-center gap-3">
            <div
                class="w-10 h-10 rounded-lg bg-gradient-to-br from-primary-violet to-primary-orange flex items-center justify-center shadow-lg shadow-primary-violet/20">
                <span class="material-symbols-outlined text-white text-xl">router</span>
            </div>
            <div>
                <p class="text-white font-bold">{{ $item['plan_nombre'] ?? 'Plan Internet' }}</p>
                <p class="text-xs text-gray-400">Alta: {{ $item['fecha_alta'] ?? 'N/A' }}</p>
            </div>
        </div>
    </td>
    <td class="px-6 py-5">
        <span class="font-mono text-gray-300">#{{ $item['codigo'] ?? $item['idContrato'] }}</span>
    </td>
    <td class="px-6 py-5 text-gray-300">
        {{ $item['franquicia_nom'] ?? 'General' }}
    </td>
    <td class="px-6 py-5">
        <x-contracts.status-badge :status="$item['estado']" />
    </td>
    <td class="px-6 py-5 text-right">
        <a href="{{ route('contracts.show', $item['id'] ?? $item['codigo']) }}" wire:navigate
            class="inline-flex items-center justify-center px-4 py-2 text-sm font-bold text-white transition-all bg-primary-violet rounded-lg hover:bg-primary-violet/80 shadow-lg shadow-primary-violet/20">
            Gestionar
            <span class="material-symbols-outlined ml-2 text-sm">settings</span>
        </a>
    </td>
</tr>
