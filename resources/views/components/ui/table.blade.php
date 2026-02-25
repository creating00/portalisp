<div {{ $attributes->merge(['class' => 'rounded-3xl border border-white/10 bg-white/5 overflow-hidden']) }}>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            {{ $slot }}
        </table>
    </div>

    @if (isset($footer))
        <div class="border-t border-white/10 px-6 py-4">
            {{ $footer }}
        </div>
    @endif
</div>
