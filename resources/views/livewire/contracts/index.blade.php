<?php
use Livewire\Volt\Component;
use App\Services\IspApiService;

new class extends Component {
    protected string $layout = 'layouts.app';

    public array $contratos = [];

    public function mount(IspApiService $api)
    {
        $token = session('api_token');
        $dni = session('cliente.dni');

        if (!$token || !$dni) {
            return redirect()->route('login');
        }

        try {
            $response = $api->getContratos($token, $dni);
            if ($response->successful()) {
                $this->contratos = $response->json();
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Fallo de conexión.');
        }
    }

    public function manage($id)
    {
        // Lógica para abrir modal o redirigir
        return redirect()->to("/contracts/{$id}");
    }
}; ?>

<div class="min-h-screen bg-[#0a051a] flex flex-col">
    <x-home.navbar />

    <main class="flex-1 py-12 px-6 lg:px-10">
        <div class="max-w-7xl mx-auto">
            <header class="mb-10">
                <h1 class="text-4xl font-extrabold tracking-tight text-white">
                    Mis <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-primary-violet to-primary-orange">Contratos</span>
                </h1>
                <p class="text-gray-400 mt-2">Gestiona tus servicios e información técnica.</p>
            </header>

            <div
                class="relative overflow-hidden rounded-2xl border border-primary-violet/20 bg-white/5 backdrop-blur-xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-primary-violet/10 border-b border-primary-violet/20 text-primary-violet text-sm font-bold uppercase tracking-wider">
                                <th class="px-6 py-4">Servicio</th>
                                <th class="px-6 py-4">ID / Nro</th>
                                <th class="px-6 py-4">Franquicia</th>
                                <th class="px-6 py-4">Estado</th>
                                <th class="px-6 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($contratos as $item)
                                <x-contracts.table-row :item="$item" />
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center">
                                        <span
                                            class="material-symbols-outlined text-5xl text-gray-600 mb-4">search_off</span>
                                        <p class="text-gray-400">No hay contratos registrados para este DNI.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <x-home.footer />
</div>
