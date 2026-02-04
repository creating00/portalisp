@props(['label', 'type', 'id', 'placeholder', 'icon', 'model'])
<div>
    <label class="block text-sm font-bold text-slate-700 mb-2" for="{{ $id }}">{{ $label }}</label>
    <div class="relative">
        <span
            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">{{ $icon }}</span>
        <input {{ $attributes->wire('model') }}
            class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary-violet/20 focus:border-primary-violet transition-all outline-none text-slate-900 placeholder:text-slate-400"
            id="{{ $id }}" type="{{ $type }}" placeholder="{{ $placeholder }}" required />
    </div>
</div>
