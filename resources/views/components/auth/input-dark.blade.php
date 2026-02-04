@props(['label', 'type', 'id', 'placeholder', 'icon', 'model'])
<div>
    <label class="block text-sm font-semibold mb-2 text-slate-300">{{ $label }}</label>
    <div class="relative">
        <span
            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-xl">{{ $icon }}</span>
        <input wire:model="{{ $model }}" type="{{ $type }}" placeholder="{{ $placeholder }}"
            class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-12 pr-4 text-white focus:border-primary-violet focus:ring-1 focus:ring-primary-violet outline-none transition-all placeholder:text-slate-600" />
    </div>
</div>
