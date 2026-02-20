<?php

use Livewire\Volt\Component;
use App\Services\IspApiService;

new class extends Component {
    public string $current_password = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';

    public function updatePassword(IspApiService $api)
    {
        $this->validate(
            [
                'current_password' => 'required',
                'new_password' => 'required|min:8|different:current_password',
                'new_password_confirmation' => 'required|same:new_password',
            ],
            [
                'new_password.different' => 'La nueva contraseña no puede ser igual a la anterior.',
                'new_password.min' => 'La contraseña debe tener al menos 8 caracteres.',
                'new_password_confirmation.same' => 'Las contraseñas no coinciden.',
            ],
        );

        $token = session('api_token');

        try {
            $response = $api->changePassword($token, $this->current_password, $this->new_password);

            if ($response->successful()) {
                $this->reset();
                session()->flash('success', 'Contraseña actualizada correctamente.');
            } else {
                $this->addError('current_password', $response->json('error') ?? 'La contraseña actual es incorrecta.');
            }
        } catch (\Throwable $e) {
            session()->flash('error', 'No se pudo conectar con el servidor central.');
        }
    }
};
?>

<form wire:submit="updatePassword" class="space-y-5">

    @if (session()->has('success'))
        <x-ui.alert type="success">{{ session('success') }}</x-ui.alert>
    @endif

    @if (session()->has('error'))
        <x-ui.alert type="error">{{ session('error') }}</x-ui.alert>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Contraseña actual (full width) --}}
        <x-ui.input-password label="Contraseña Actual" model="current_password" colspan="md:col-span-2" />

        {{-- Nueva contraseña --}}
        <x-ui.password-strength model="new_password" label="Nueva Contraseña" hint="Mínimo 8 caracteres" />

        {{-- Confirmación --}}
        <x-ui.input-password label="Confirmar Nueva" model="new_password_confirmation" />
    </div>

    <div class="pt-4 text-right">
        <x-ui.submit-button wire-target="updatePassword">
            Actualizar Contraseña
        </x-ui.submit-button>
    </div>
</form>
