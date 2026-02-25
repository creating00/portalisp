<div class="dark min-h-screen bg-[#0a051a]">
    <x-home.navbar />
    <main class="max-w-7xl mx-auto py-12 px-6">
        {{-- Botón volver (Simulado) --}}
        <div class="h-6 w-40 bg-white/5 rounded mb-8 animate-pulse"></div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            {{-- Columna Lateral --}}
            <div class="lg:col-span-1">
                <div class="h-80 bg-white/5 border border-white/10 rounded-3xl animate-pulse relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary-violet/5 to-transparent"></div>
                </div>
            </div>

            {{-- Columna Tabla --}}
            <div class="lg:col-span-3">
                <x-ui.table-skeleton />
            </div>
        </div>
    </main>
</div>
