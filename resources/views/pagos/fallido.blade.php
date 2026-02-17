<x-app-layout>
    <div class="min-h-[60vh] flex items-center justify-center px-4">
        <div
            class="max-w-md w-full bg-white/5 border border-white/10 rounded-3xl p-8 backdrop-blur-sm shadow-2xl text-center">
            {{-- Icono de Error --}}
            <div
                class="mb-6 inline-flex items-center justify-center w-20 h-20 bg-red-500/10 rounded-full border border-red-500/20">
                <span class="material-symbols-outlined text-5xl text-red-400">error</span>
            </div>

            <h1 class="text-3xl font-bold text-white mb-2">Pago Fallido</h1>
            <p class="text-gray-400 mb-8">
                No pudimos procesar la transacción. No se ha realizado ningún cargo a tu cuenta.
            </p>

            <div class="flex flex-col gap-3">
                <a href="{{ route('contracts.index') }}"
                    class="flex items-center justify-center w-full py-3 bg-white/10 rounded-xl text-white font-bold hover:bg-white/20 transition-all">
                    Intentar nuevamente
                </a>
                <span class="text-sm text-gray-500">O ponte en contacto con soporte técnico.</span>
            </div>
        </div>
    </div>
</x-app-layout>
