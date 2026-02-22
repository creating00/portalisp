<form wire:submit="updatePassword" class="space-y-5">

    {{-- Alertas --}}
    @if (session()->has('success'))
        <x-ui.alert type="success">
            {{ session('success') }}
        </x-ui.alert>
    @endif

    @if (session()->has('error'))
        <x-ui.alert type="error">
            {{ session('error') }}
        </x-ui.alert>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Contraseña actual --}}
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-400 mb-2">
                Contraseña Actual
            </label>
            <input type="password" wire:model="current_password"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-primary-violet transition-all outline-none">
            @error('current_password')
                <span class="text-red-400 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Nueva contraseña --}}
        <x-ui.password-strength model="new_password" label="Nueva Contraseña" placeholder="Mínimo 8 caracteres" />

        {{-- Confirmación --}}
        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">
                Confirmar Nueva
            </label>
            <input type="password" wire:model="new_password_confirmation"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-primary-violet transition-all outline-none">
            @error('new_password_confirmation')
                <span class="text-red-400 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>
    </div>

    {{-- Submit --}}
    <div class="pt-4 text-right">
        <button type="submit" wire:loading.attr="disabled"
            class="bg-primary-violet hover:bg-primary-violet/90 text-white font-bold py-3 px-8 rounded-xl transition-all flex items-center gap-2 ml-auto disabled:opacity-50 disabled:cursor-not-allowed">
            <span wire:loading wire:target="updatePassword" class="animate-spin material-symbols-outlined text-sm">
                sync
            </span>
            <span>Actualizar Contraseña</span>
        </button>
    </div>

</form>
