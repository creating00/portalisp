@props(['model', 'label', 'colspan' => null, 'hint' => null])

<div @class(['w-full', $colspan]) x-data="{
    password: @entangle($model),
    rules: {
        length: false,
        upper: false,
        number: false,
        symbol: false,
    },
    get strength() {
        let s = 0;
        if (this.rules.length) s++;
        if (this.rules.upper) s++;
        if (this.rules.number) s++;
        if (this.rules.symbol) s++;
        return s;
    },
    get strengthColor() {
        return ['bg-gray-700', 'bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-emerald-500'][this.strength];
    },
    get strengthText() {
        return ['', 'Débil', 'Media', 'Buena', 'Fuerte'][this.strength];
    },
    check() {
        this.rules.length = this.password?.length >= 8;
        this.rules.upper = /[A-Z]/.test(this.password);
        this.rules.number = /[0-9]/.test(this.password);
        this.rules.symbol = /[^A-Za-z0-9]/.test(this.password);
    }
}" x-effect="check()">
    {{-- Label --}}
    <label class="block text-sm font-medium text-gray-400 mb-2">
        {{ $label }}
    </label>

    {{-- Input --}}
    <input type="password" x-model="password"
        {{ $attributes->merge([
            'class' => 'w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3
                                text-white focus:ring-2 focus:ring-primary-violet transition-all outline-none',
        ]) }}>

    {{-- Error y Hint (Justo debajo del input) --}}
    <div class="flex justify-between items-start mt-1">
        @if ($hint)
            <p class="text-[10px] text-gray-500 uppercase font-medium">
                {{ $hint }}
            </p>
        @endif

        @error($model)
            <span class="text-red-400 text-[10px] font-bold uppercase ml-auto">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Checklist --}}
    <ul x-show="password" x-transition.opacity.duration.300ms class="mt-3 space-y-1 text-[11px]">
        <template x-for="(ok, key) in rules" :key="key">
            <li class="flex items-center gap-2 transition-all duration-300"
                :class="ok ? 'text-emerald-400' : 'text-gray-500'">
                <span class="material-symbols-outlined text-xs transition-transform duration-300"
                    :class="ok ? 'scale-100' : 'scale-75 opacity-50'">
                    check_circle
                </span>
                <span
                    x-text="{
                    length: 'Mínimo 8 caracteres',
                    upper:  'Una mayúscula',
                    number: 'Un número',
                    symbol: 'Un símbolo'
                }[key]"></span>
            </li>
        </template>
    </ul>

    {{-- Strength bar --}}
    <div class="flex gap-1 mt-3 h-1.5">
        <template x-for="i in 4">
            <div class="flex-1 rounded-full transition-all duration-500"
                :class="i <= strength ? strengthColor + ' scale-y-110' : 'bg-white/10'"></div>
        </template>
    </div>

    {{-- Footer (Solo el texto de fuerza) --}}
    <div class="mt-2 text-right">
        <span x-show="password" x-transition.opacity.duration.300ms class="text-[10px] uppercase font-bold"
            :class="strength >= 3 ? 'text-emerald-400' : 'text-gray-400'" x-text="strengthText"></span>
    </div>
</div>
