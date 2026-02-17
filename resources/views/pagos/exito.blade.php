<x-app-layout>
    <div class="min-h-[60vh] flex items-center justify-center px-4">
        <div
            class="max-w-md w-full bg-white/5 border border-white/10 rounded-3xl p-8 backdrop-blur-sm shadow-2xl text-center">
            {{-- Icono Animado --}}
            <div
                class="mb-6 inline-flex items-center justify-center w-20 h-20 bg-emerald-500/10 rounded-full border border-emerald-500/20">
                <span class="material-symbols-outlined text-5xl text-emerald-400">check_circle</span>
            </div>

            <h1 class="text-3xl font-bold text-white mb-2">¡Pago Recibido!</h1>
            <p class="text-gray-400 mb-8">
                Tu comprobante ha sido procesado. En unos instantes verás reflejado el cambio en tu estado de cuenta.
            </p>

            <div class="space-y-3">
                <a href="{{ route('contracts.index') }}"
                    class="flex items-center justify-center w-full py-3 bg-primary-violet rounded-xl text-white font-bold hover:bg-primary-violet/80 transition-all shadow-lg shadow-primary-violet/20">
                    Ir a mis Contratos
                </a>

                <p class="text-xs text-gray-500 italic">
                    Serás redirigido automáticamente en <span id="countdown">5</span> segundos...
                </p>
            </div>
        </div>
    </div>

    <script>
        let seconds = 5;
        const countdownEl = document.getElementById('countdown');
        const interval = setInterval(() => {
            seconds--;
            countdownEl.textContent = seconds;
            if (seconds <= 0) {
                clearInterval(interval);
                window.location.href = "{{ route('contracts.index') }}";
            }
        }, 1000);
    </script>
</x-app-layout>
