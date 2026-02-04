<div {{ $attributes->merge(['class' => 'rounded-3xl border border-white/10 bg-white/5 overflow-hidden']) }}>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            {{ $slot }}
        </table>
    </div>
</div>
