@props(['cliente'])

<x-ui.glass-card class="p-6">
    <div class="flex flex-col items-center text-center mb-6">
        <div
            class="w-20 h-20 rounded-full bg-primary-violet/20 border border-primary-violet/30 flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-4xl text-primary-violet">person</span>
        </div>

        <h3 class="text-xl font-bold text-white">
            {{ $cliente['nombre'] }} {{ $cliente['apellido'] }}
        </h3>
        <p class="text-gray-400 text-sm">Cliente #{{ $cliente['id'] }}</p>
    </div>

    <div class="space-y-4 pt-4 border-t border-white/5">
        <div>
            <p class="text-[10px] uppercase font-bold text-gray-500">DNI / Documento</p>
            <p class="text-white font-medium">{{ $cliente['dni'] }}</p>
        </div>
        <div>
            <p class="text-[10px] uppercase font-bold text-gray-500">Email registrado</p>
            <p class="text-white font-medium">{{ $cliente['email'] }}</p>
        </div>
    </div>
</x-ui.glass-card>
