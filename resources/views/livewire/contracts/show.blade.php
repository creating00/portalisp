<?php
use Livewire\Volt\Component;
use App\Services\IspApiService;

new class extends Component {
    protected string $layout = 'layouts.app';

    public int $contratoId;
    public array $facturas = [];
    public array $contrato = [];

    public function mount(int $id, IspApiService $api)
    {
        $this->contratoId = $id;
        $token = session('api_token');

        try {
            $response = $api->getFacturas($token, $id);
            if ($response->successful()) {
                $this->facturas = $response->json();
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error al cargar facturas.');
        }
    }
}; ?>

<div class="min-h-screen bg-[#0a051a]">
    <x-home.navbar />

    <main class="max-w-7xl mx-auto py-12 px-6">
        {{-- Breadcrumb mejorado --}}
        <a href="{{ route('contracts.index') }}" wire:navigate
            class="group inline-flex items-center gap-2 mb-8 text-gray-400 hover:text-primary-violet transition-colors">
            <span class="material-symbols-outlined transition-transform group-hover:-translate-x-1">arrow_back</span>
            <span class="font-medium">Volver a mis contratos</span>
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            {{-- Card Lateral: Resumen del Contrato --}}
            <div class="lg:col-span-1 space-y-6">
                <div
                    class="p-8 rounded-3xl border border-white/10 bg-white/5 backdrop-blur-xl relative overflow-hidden group">
                    {{-- Decoración de fondo --}}
                    <div
                        class="absolute -right-4 -top-4 w-24 h-24 bg-primary-violet/10 rounded-full blur-2xl group-hover:bg-primary-violet/20 transition-colors">
                    </div>

                    <h3 class="text-xl font-bold text-white mb-6">Detalle del Servicio</h3>

                    <div class="space-y-6 relative">
                        <div>
                            <p class="text-xs uppercase tracking-wider text-gray-500 font-bold mb-1">ID Contrato</p>
                            <p class="text-2xl font-mono text-white">#{{ $contratoId }}</p>
                        </div>

                        <div>
                            <p class="text-xs uppercase tracking-wider text-gray-500 font-bold mb-2">Estado General</p>
                            <x-contracts.status-badge status="activo" />
                        </div>

                        <div class="pt-6 border-t border-white/5">
                            <div class="flex items-center gap-3 text-gray-400">
                                <span class="material-symbols-outlined text-primary-violet">calendar_today</span>
                                <span class="text-sm font-medium">Ciclo de facturación mensual</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Listado de Facturas --}}
            <div class="lg:col-span-3 space-y-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                        Historial de Facturación
                        <span
                            class="px-2.5 py-0.5 rounded-md bg-white/5 text-xs text-gray-400 border border-white/10">{{ count($facturas) }}
                            Items</span>
                    </h2>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 overflow-hidden">
                    <div class="overflow-x-auto">
                        <x-ui.table>
                            <x-ui.table-head>
                                <x-ui.table-th>Período</x-ui.table-th>
                                <x-ui.table-th>Vencimiento</x-ui.table-th>
                                <x-ui.table-th class="text-center">Monto</x-ui.table-th>
                                <x-ui.table-th class="text-center">Estado</x-ui.table-th>
                                <x-ui.table-th class="text-right">Acciones</x-ui.table-th>
                            </x-ui.table-head>

                            <x-ui.table-body>
                                @forelse($facturas as $f)
                                    <tr class="group hover:bg-white/[0.04] transition-colors">
                                        <x-ui.table-td>
                                            <p class="text-white font-bold">{{ $f['periodo'] }}</p>
                                        </x-ui.table-td>

                                        <x-ui.table-td>{{ $f['vencimiento'] }}</x-ui.table-td>

                                        <x-ui.table-td class="text-center">
                                            <x-ui.money :amount="$f['total']" :status="strtolower($f['estado'])" />
                                        </x-ui.table-td>

                                        <x-ui.table-td class="text-center">
                                            <x-contracts.status-badge :status="strtolower($f['estado'])" />
                                        </x-ui.table-td>

                                        <x-ui.table-td class="text-right">
                                            <div class="flex justify-end gap-2">
                                                @if (strtolower($f['estado']) === 'pendiente')
                                                    <x-contracts.action-button type="pay" />
                                                @else
                                                    {{-- Botón de descarga para las pagadas --}}
                                                    <x-contracts.action-button type="download" />
                                                @endif
                                            </div>
                                        </x-ui.table-td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-20 text-center opacity-40">
                                            No hay registros
                                        </td>
                                    </tr>
                                @endforelse
                            </x-ui.table-body>
                        </x-ui.table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <x-home.footer />
</div>
