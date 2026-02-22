@props(['factura', 'mpDisponible' => false, 'saldoMonedero' => 0])

@php
    // Es mejor usar el namespace completo para evitar errores de sintaxis con 'use' dentro de Blade
    $status = \App\Enums\StatusType::tryFrom(strtolower($factura['estado']));
@endphp

<div class="flex justify-end gap-2 items-center">
    @if ($status && $status->puedePagar())
        {{-- Botón Mercado Pago --}}
        @if ($mpDisponible)
            <button onclick="iniciarPago({{ $factura['id'] }})"
                class="group flex items-center justify-center px-5 py-1.5 bg-[#009ee3] hover:bg-[#008ad2] rounded-xl transition-all shadow-lg shadow-blue-500/25 active:scale-95 border border-white/10"
                title="Pagar con Mercado Pago">
                <div class="h-8 flex items-center transition-transform duration-300 group-hover:scale-110">
                    <img src="{{ asset('img/MP_RGB_HANDSHAKE_pluma_horizontal.svg') }}" alt="Mercado Pago"
                        class="h-full w-auto">
                </div>
            </button>
        @endif

        {{-- Botón Transferencia --}}
        <button
            wire:click="$dispatch('openModalTransferencia', {
                facturaId: {{ $factura['id'] }}, 
                monto: {{ $factura['total'] }}, 
                alias: '{{ $factura['alias_transferencia'] ?? 'No disponible' }}',
                saldoMonedero: {{ $saldoMonedero }}
            })"
            class="group flex items-center gap-2 px-4 py-2 border border-white/10 hover:bg-white/5 text-gray-400 hover:text-white rounded-xl transition-all"
            title="Informar Transferencia">
            <span class="material-symbols-outlined text-[18px]">upload_file</span>
            <span class="text-xs font-medium">Informar</span>
        </button>
    @elseif($status === \App\Enums\StatusType::REVISION)
        {{-- Estado informativo --}}
        <div
            class="flex items-center gap-2 px-3 py-1.5 rounded-xl border border-indigo-500/20 bg-indigo-500/5 text-indigo-400">
            <span class="material-symbols-outlined text-[16px] animate-pulse">hourglass_empty</span>
            <span class="text-[10px] font-bold uppercase tracking-wider">Esperando validación</span>
        </div>
    @else
        <span class="text-xs text-gray-500 italic px-2">Sin acciones pendientes</span>
    @endif
</div>
