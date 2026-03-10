<div {{ $attributes->merge([
    'class' => 'rounded-3xl border border-white/10 bg-white/5 backdrop-blur-xl',
]) }}>
    {{ $slot }}
</div>
