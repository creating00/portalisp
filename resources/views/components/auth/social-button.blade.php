@props(['provider', 'icon'])

<button type="button" class="w-full flex items-center justify-center gap-3 bg-white border border-slate-200 text-slate-700 py-3.5 rounded-xl font-bold transition-all hover:bg-slate-50">
    <img alt="{{ $provider }}" class="w-5 h-5" src="{{ $icon }}"/>
    Sign in with {{ $provider }}
</button>