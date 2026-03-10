<?php
use Livewire\Volt\Component;
use App\Services\IspApiService;

new class extends Component {
    protected string $layout = 'layouts.app';

    // Datos visuales del cliente
    public array $cliente = [];

    // Formulario de contraseña
    public string $current_password = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';

    public function mount()
    {
        // El middleware api.auth ya garantiza que existe la sesión
        $this->cliente = session('cliente', []);
    }

    public function goHome()
    {
        return redirect()->route('home.index');
    }
}; ?>

<div class="min-h-screen bg-[#0a051a] py-12 px-6">
    <div class="max-w-4xl mx-auto">

        {{-- Volver --}}
        <x-ui.back-link :href="route('home.index')" variant="subtle">
            Regresar
        </x-ui.back-link>

        <h2 class="text-3xl font-bold text-white mb-8">Mi Perfil</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- Info del Cliente --}}
            <x-profile.client-card :cliente="$cliente" />

            {{-- Seguridad --}}
            <div class="md:col-span-2">
                <x-ui.glass-card class="p-8">
                    <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary-violet">lock</span>
                        Seguridad y Acceso
                    </h3>

                    <livewire:profile.security-form />
                </x-ui.glass-card>
            </div>

        </div>
    </div>
</div>
