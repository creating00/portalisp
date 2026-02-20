@props([
    'wireTarget' => null,
])

<button type="submit" @if ($wireTarget) wire:loading.attr="disabled" @endif
    {{ $attributes->merge([
        'class' =>
            'bg-primary-violet hover:bg-primary-violet/90 text-white font-bold py-3 px-8 rounded-xl transition-all flex items-center gap-2 ml-auto disabled:opacity-50 disabled:cursor-not-allowed',
    ]) }}>
    @if ($wireTarget)
        <span wire:loading wire:target="{{ $wireTarget }}" class="animate-spin material-symbols-outlined text-sm">
            sync
        </span>
    @endif

    <span>{{ $slot }}</span>
</button>
