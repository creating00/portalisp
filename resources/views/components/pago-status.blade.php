@props([
    'type' => 'success',
    'title',
    'buttonText',
    'buttonLink',
    'icon',
    'redirect' => null, // Ruta opcional para redirección automática
    'seconds' => 5, // Tiempo personalizable
])

@php
    $isSuccess = $type === 'success';
    $containerClasses =
        'max-w-md w-full p-8 text-center shadow-2xl backdrop-blur-md rounded-3xl border animate-in fade-in slide-in-from-bottom-4 duration-700 bg-white/70 border-white/50 dark:bg-brand-dark/40 dark:border-white/10 dark:glass-card';

    $iconClasses = $isSuccess
        ? 'bg-emerald-50 text-emerald-500 border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20 animate-bounce'
        : 'bg-red-50 text-red-500 border-red-200 dark:bg-red-500/10 dark:text-red-400 dark:border-red-500/20 animate-shake';

    $buttonClasses = $isSuccess
        ? 'bg-primary-violet text-white shadow-lg shadow-primary-violet/20 hover:bg-primary-violet/90'
        : 'bg-primary-violet text-white orange-glow dark:bg-white/10 dark:hover:bg-white/20 dark:shadow-none';
@endphp

<div class="min-h-[60vh] flex items-center justify-center px-4 violet-gradient-bg">
    <div class="{{ $containerClasses }}">
        <div class="mb-6 inline-flex items-center justify-center w-20 h-20 rounded-full border {{ $iconClasses }}">
            <span class="material-symbols-outlined text-5xl">{{ $icon }}</span>
        </div>

        <h1 class="text-3xl font-bold mb-2 text-gray-900 dark:text-white">
            {{ $title }}
        </h1>

        <div class="mb-8 text-gray-600 dark:text-gray-400 text-balance">
            {{ $slot }}
        </div>

        <div class="flex flex-col gap-3">
            <a href="{{ $buttonLink }}"
                class="flex items-center justify-center w-full py-3 font-bold transition-all rounded-xl hover:scale-[1.02] active:scale-[0.98] {{ $buttonClasses }}">
                {{ $buttonText }}
            </a>

            @if ($redirect)
                <p class="text-xs text-gray-500 italic dark:text-gray-500">
                    Serás redirigido automáticamente en <span id="countdown"
                        class="font-bold">{{ $seconds }}</span> segundos...
                </p>

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        let seconds = {{ $seconds }};
                        const countdownEl = document.getElementById('countdown');
                        const interval = setInterval(() => {
                            seconds--;
                            if (countdownEl) countdownEl.textContent = seconds;
                            if (seconds <= 0) {
                                clearInterval(interval);
                                window.location.href = "{{ $redirect }}";
                            }
                        }, 1000);
                    });
                </script>
            @endif

            {{ $footer ?? '' }}
        </div>
    </div>
</div>
