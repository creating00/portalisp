@props([
    'label',
    'model',
    'colspan' => null, // ej: 'md:col-span-2'
])

<div @class([$colspan])>
    <label class="block text-sm font-medium text-gray-400 mb-2">
        {{ $label }}
    </label>

    <input type="password" wire:model="{{ $model }}"
        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white
               focus:ring-2 focus:ring-primary-violet transition-all outline-none">

    @error($model)
        <span class="text-red-400 text-xs mt-1">{{ $message }}</span>
    @enderror
</div>
