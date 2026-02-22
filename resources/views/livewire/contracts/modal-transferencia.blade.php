<?php
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use App\Services\IspApiService;

new class extends Component {
    use WithFileUploads;

    public $show = false;
    public $facturaId;
    public $monto; // Total de la factura (solo lectura para el usuario)
    public $montoInformado; // Lo que el usuario dice haber transferido
    public $saldoMonedero = 0; // Saldo disponible del cliente
    public $usarMonedero = false;
    public $alias;
    public $comprobante;
    public $observaciones;
    public $enviarExcedente = true;

    protected $listeners = ['openModalTransferencia' => 'loadData'];

    public function loadData($facturaId = null, $monto = null, $alias = null, $saldoMonedero = 0)
    {
        $this->reset(['comprobante', 'observaciones', 'usarMonedero']);
        $this->facturaId = $facturaId;
        $this->monto = (float) $monto;
        $this->saldoMonedero = (float) $saldoMonedero;
        $this->montoInformado = $this->monto;
        $this->alias = $alias;
        $this->show = true;
    }

    // Hook que reacciona cuando cambia el checkbox 'usarMonedero'
    public function updatedUsarMonedero($value)
    {
        if ($value) {
            // Resta el saldo al total, mínimo 0
            $this->montoInformado = max(0, $this->monto - $this->saldoMonedero);
        } else {
            $this->montoInformado = $this->monto;
        }
    }

    public function enviarComprobante(IspApiService $api)
    {
        $this->validate([
            'comprobante' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
            'montoInformado' => 'required|numeric|min:0',
        ]);

        try {
            $dto = new \App\DTOs\SubirComprobanteDTO(facturaId: (int) $this->facturaId, file: $this->comprobante, monto: (float) $this->montoInformado, observaciones: $this->observaciones, enviarExcedente: (bool) $this->enviarExcedente, usarSaldoMonedero: (bool) $this->usarMonedero);

            $response = $api->subirComprobante(session('api_token'), $dto);

            if ($response->successful()) {
                $this->show = false;
                $this->dispatch('notify', '¡Listo! Comprobante enviado.');
                $this->dispatch('refreshFacturas');
            } else {
                $error = $response->json()['error'] ?? 'Error en el servidor central.';
                session()->flash('error', $error);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error crítico: ' . $e->getMessage());
        }
    }
}; ?>

<div>
    @if ($show)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
            <div class="bg-[#150d2d] border border-white/10 p-8 rounded-3xl max-w-md w-full shadow-2xl">

                {{-- 1. Encabezado y Contexto --}}
                <h3 class="text-xl font-bold text-white mb-1">Informar Transferencia</h3>
                <p class="text-gray-400 text-sm mb-6">Factura #{{ $facturaId }} - Total:
                    ${{ number_format($monto, 2) }}</p>

                @if ($alias)
                    {{-- Alias (si existe) --}}
                    <div class="mb-6 p-4 rounded-2xl bg-primary-violet/10 border border-primary-violet/20">
                        <p class="text-xs uppercase tracking-wider text-primary-violet font-bold mb-1">Alias para
                            transferencia</p>
                        <div class="flex items-center justify-between">
                            <span class="text-white font-mono font-medium">{{ $alias }}</span>
                            <button type="button" onclick="navigator.clipboard.writeText('{{ $alias }}')"
                                class="text-xs bg-primary-violet/20 hover:bg-primary-violet/40 text-primary-violet px-2 py-1 rounded-md transition-colors">
                                Copiar
                            </button>
                        </div>
                    </div>
                @endif

                <form wire:submit.prevent="enviarComprobante" class="space-y-4">
                    {{-- Grid de 2 columnas para Monto y Opciones --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        {{-- 2. CAMPO DE MONTO --}}
                        <div class="bg-white/5 border border-white/10 rounded-2xl p-4 flex flex-col justify-center">
                            <label class="text-[10px] uppercase tracking-widest text-gray-500 font-bold mb-1 block">
                                Monto a Transferir ($)
                            </label>
                            <input type="number" step="0.01" wire:model="montoInformado"
                                class="w-full bg-transparent text-xl font-bold text-primary-violet outline-none border-none p-0 focus:ring-0"
                                placeholder="0.00">
                            @error('montoInformado')
                                <span class="text-[10px] text-red-500 mt-1 block leading-none">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Contenedor de Opciones (Saldo y Excedente) --}}
                        <div class="space-y-2">
                            {{-- Checkbox: Usar Saldo (Solo si hay saldo) --}}
                            @if ($saldoMonedero > 0)
                                <div
                                    class="bg-white/5 border border-white/10 rounded-2xl p-3 flex items-center gap-3 group cursor-pointer">
                                    <input type="checkbox" wire:model.live="usarMonedero" id="usarMonedero"
                                        class="w-5 h-5 rounded border-white/10 bg-white/5 text-primary-violet focus:ring-primary-violet transition-all">
                                    <label for="usarMonedero"
                                        class="text-[11px] text-gray-400 cursor-pointer leading-tight group-hover:text-gray-200 transition-colors">
                                        Usar saldo: <span
                                            class="text-green-500 font-bold">${{ number_format($saldoMonedero, 2) }}</span>
                                    </label>
                                </div>
                            @endif

                            {{-- Checkbox: Acreditar Excedente --}}
                            <div
                                class="bg-white/5 border border-white/10 rounded-2xl p-3 flex items-center gap-3 group cursor-pointer">
                                <input type="checkbox" wire:model="enviarExcedente" id="excedente"
                                    class="w-5 h-5 rounded border-white/10 bg-white/5 text-primary-violet focus:ring-primary-violet transition-all">
                                <label for="excedente"
                                    class="text-[11px] text-gray-400 cursor-pointer leading-tight group-hover:text-gray-200 transition-colors">
                                    Acreditar excedente en monedero
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- 3. CONTENEDOR DE SUBIDA (Ancho completo para mejor dropzone) --}}
                    <div
                        class="border-2 border-dashed border-white/10 rounded-2xl p-4 text-center hover:border-primary-violet/50 transition-colors group relative">
                        <input type="file" wire:model="comprobante" id="file-upload" class="hidden">

                        <label for="file-upload" class="cursor-pointer flex items-center justify-center gap-4">
                            <div
                                class="bg-primary-violet/10 p-2 rounded-lg group-hover:bg-primary-violet/20 transition-colors">
                                <span
                                    class="material-symbols-outlined text-2xl text-primary-violet block">cloud_upload</span>
                            </div>
                            <div class="text-left">
                                <span class="text-sm text-gray-300 font-medium block">
                                    {{ $comprobante ? Str::limit($comprobante->getClientOriginalName(), 20) : 'Comprobante de pago' }}
                                </span>
                                <span class="text-[10px] text-gray-500 uppercase tracking-tighter">JPG, PNG o PDF (Máx
                                    2MB)</span>
                            </div>
                        </label>

                        {{-- Loading state --}}
                        <div wire:loading wire:target="comprobante"
                            class="absolute inset-0 bg-[#150d2d]/90 rounded-2xl flex items-center justify-center gap-2">
                            <div
                                class="w-4 h-4 border-2 border-primary-violet border-t-transparent rounded-full animate-spin">
                            </div>
                            <span class="text-xs text-primary-violet font-medium">Subiendo...</span>
                        </div>
                    </div>

                    @error('comprobante')
                        <span class="text-xs text-red-500 block text-center">{{ $message }}</span>
                    @enderror

                    {{-- 4. NOTAS --}}
                    <textarea wire:model="observaciones" placeholder="¿Algún comentario sobre este pago?"
                        class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-white text-sm focus:border-primary-violet outline-none min-h-[80px] transition-all resize-none"></textarea>

                    {{-- 6. BOTONES --}}
                    <div class="flex gap-3 pt-2">
                        <button type="button" wire:click="$set('show', false)"
                            class="flex-1 px-4 py-3 text-sm font-medium text-gray-400 hover:text-white transition-colors">
                            Cancelar
                        </button>

                        <button type="submit" wire:loading.attr="disabled"
                            class="flex-[2] px-4 py-3 bg-primary-violet rounded-xl text-white font-bold hover:bg-primary-violet/80 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 shadow-lg shadow-primary-violet/20">

                            <span wire:loading.remove wire:target="enviarComprobante">Informar Pago</span>

                            <div wire:loading wire:target="enviarComprobante" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                <span class="text-sm">Procesando...</span>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
