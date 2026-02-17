<header class="sticky top-0 z-50 w-full border-b border-primary-violet/20 glass-nav">
    <div class="mx-auto max-w-7xl px-6 lg:px-10 h-20 flex items-center justify-between">

        {{-- Logo --}}
        <div class="flex items-center gap-3">
            <div class="bg-primary-violet p-1.5 rounded-lg">
                <span class="material-symbols-outlined text-white font-bold">all_inclusive</span>
            </div>
            <h2
                class="text-2xl font-extrabold tracking-tighter bg-clip-text text-transparent bg-gradient-to-r from-primary-violet to-primary-orange">
                YnfinitY
            </h2>
        </div>

        {{-- Navegación --}}
        <nav class="hidden md:flex items-center gap-10">
            <x-nav.link href="/" :active="request()->is('/')">Home</x-nav.link>
        </nav>

        {{-- Acciones --}}
        <div class="flex items-center gap-6">

            {{-- Usuario logueado --}}
            @authsession
            <x-nav.dropdown label="{{ session('cliente.nombre') }}">
                <x-nav.dropdown-header label="User Options" />

                <x-nav.dropdown-item href="/my-contracts" icon="description">
                    My Contracts
                </x-nav.dropdown-item>
                <hr class="border-white/5 my-2 mx-2">
                <livewire:auth.logout-button />
            </x-nav.dropdown>
            @endauthsession

            {{-- Invitado --}}
            @guestsession
            <x-nav.link href="/login" class="hidden sm:block font-bold text-sm">
                Login
            </x-nav.link>

            <x-nav.button href="/register">
                Register
            </x-nav.button>
            @endguestsession

        </div>
    </div>
</header>
