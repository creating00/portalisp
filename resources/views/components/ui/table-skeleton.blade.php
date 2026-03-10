<div class="space-y-6 animate-pulse">
    <div class="flex items-center justify-between mb-4">
        <div class="h-8 bg-white/10 rounded-lg w-48"></div>
        <div class="h-6 bg-white/5 rounded-md w-20"></div>
    </div>

    <div class="rounded-3xl border border-white/10 bg-white/5 overflow-hidden relative">
        {{-- Brillo de carga lateral --}}
        <div
            class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent -translate-x-full animate-[shimmer_2s_infinite]">
        </div>

        <div class="p-6 space-y-4">
            @foreach (range(1, 5) as $i)
                <div class="flex items-center justify-between py-4 border-b border-white/5 last:border-0">
                    <div class="flex flex-col gap-2">
                        <div class="h-4 bg-white/10 rounded w-24"></div>
                        <div class="h-3 bg-white/5 rounded w-16"></div>
                    </div>
                    <div class="h-6 bg-primary-violet/15 rounded-full w-20"></div>
                    <div class="h-8 bg-white/10 rounded-xl w-32"></div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Footer / Paginación simulada --}}
    <div class="mt-6 flex items-center justify-between px-2">
        <div class="h-4 bg-white/5 rounded w-32"></div> {{-- Texto "Mostrando..." --}}
        <div class="flex gap-2">
            <div class="h-10 w-10 bg-white/5 rounded-xl"></div> {{-- Botón Prev --}}
            <div class="h-10 w-10 bg-white/10 rounded-xl border border-primary-violet/20"></div> {{-- Botón Actual --}}
            <div class="h-10 w-10 bg-white/5 rounded-xl"></div> {{-- Botón Next --}}
        </div>
    </div>
</div>
