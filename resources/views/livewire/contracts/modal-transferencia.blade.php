<?php
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use App\Services\IspApiService;

new class extends Component {
    use WithFileUploads;

    public $show = false;
    public $facturaId;
    public $monto;
    public $alias;
    public $comprobante;
    public $observaciones;

    protected $listeners = ['openModalTransferencia' => 'loadData'];

    public function loadData($facturaId = null, $monto = null, $alias = null)
    {
        $this->reset(['comprobante', 'observaciones']);
        $this->facturaId = $facturaId;
        $this->monto = $monto;
        $this->alias = $alias;
        $this->show = true;
    }

    public function enviarComprobante(IspApiService $api)
    {
        $this->validate([
            'comprobante' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        try {
            $response = $api->subirComprobante(session('api_token'), $this->facturaId, $this->comprobante, $this->observaciones, $this->monto);

            if ($response->successful()) {
                // 1. Cerramos el modal (estado local)
                $this->show = false;

                // 2. Notificamos al usuario
                $this->dispatch('notify', '¡Listo! Comprobante enviado.');

                // 3. Avisamos al componente 'show' que recargue las facturas
                $this->dispatch('refreshFacturas');
            } else {
                $error = $response->json()['error'] ?? 'Error en el servidor central.';
                session()->flash('error', $error);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error crítico: ' . $e->getMessage());
        }
    }

    public function guardarTransferencia()
    {
        // $this->comprobante es una instancia de UploadedFile (Livewire)
        $response = $this->apiService->subirComprobante(session('token'), $this->facturaId, $this->comprobante, $this->observaciones);

        if ($response->successful()) {
            $this->dispatch('notify', 'Comprobante enviado con éxito. Pendiente de validación.');
            $this->closeModal();
        }
    }
}; ?>

<div>
    @if ($show)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
            <div class="bg-[#150d2d] border border-white/10 p-8 rounded-3xl max-w-md w-full shadow-2xl">
                <h3 class="text-xl font-bold text-white mb-2">Informar Transferencia</h3>
                <p class="text-gray-400 text-sm mb-6">Factura #{{ $facturaId }} - Total: ${{ $monto }}</p>

                {{-- Dentro del modal, arriba del formulario --}}
                @if ($alias)
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
                    {{-- Contenedor de subida --}}
                    <div
                        class="border-2 border-dashed border-white/10 rounded-2xl p-6 text-center hover:border-primary-violet/50 transition-colors">
                        <input type="file" wire:model="comprobante" id="file-upload" class="hidden">

                        <label for="file-upload" class="cursor-pointer flex flex-col items-center">
                            <span
                                class="material-symbols-outlined text-4xl text-primary-violet mb-2">cloud_upload</span>
                            <span class="text-sm text-gray-300">
                                {{ $comprobante ? $comprobante->getClientOriginalName() : 'Subir imagen o PDF' }}
                            </span>
                        </label>

                        {{-- Aparece solo mientras el archivo se sube al servidor temporal --}}
                        <div wire:loading wire:target="comprobante"
                            class="text-xs text-amber-500 animate-pulse mt-3 flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-sm">sync</span>
                            Subiendo archivo, espera un momento...
                        </div>

                        {{-- Error de validación --}}
                        @error('comprobante')
                            <span class="text-xs text-red-500 mt-2 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Notas --}}
                    <textarea wire:model="observaciones" placeholder="Nota opcional..."
                        class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-white text-sm focus:border-primary-violet outline-none"></textarea>

                    {{-- Botones --}}
                    <div class="flex gap-3 pt-4">
                        <button type="button" wire:click="$set('show', false)"
                            class="flex-1 px-4 py-2 text-gray-400 hover:text-white transition-colors">Cancelar</button>

                        <button type="submit" wire:loading.attr="disabled"
                            class="flex-1 px-4 py-2 bg-primary-violet rounded-xl text-white font-bold hover:bg-primary-violet/80 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">

                            <span wire:loading.remove wire:target="enviarComprobante">Enviar Pago</span>

                            <span wire:loading wire:target="enviarComprobante" class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Procesando...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
