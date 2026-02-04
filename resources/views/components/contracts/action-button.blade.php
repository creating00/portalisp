@props(['type' => 'download', 'label' => ''])

@if ($type === 'pay')
    <button
        {{ $attributes->merge(['class' => 'group relative inline-flex items-center justify-center px-4 py-2 font-bold text-white transition-all duration-200 bg-gradient-to-r from-primary-orange to-orange-600 rounded-xl hover:shadow-[0_0_20px_rgba(249,115,22,0.4)] active:scale-95']) }}>
        <span class="material-symbols-outlined mr-2 text-sm group-hover:animate-pulse">payments</span>
        {{ $label ?: 'Pagar Ahora' }}
    </button>
@else
    <button
        {{ $attributes->merge(['class' => 'inline-flex items-center justify-center p-2 text-primary-violet transition-all duration-200 border border-primary-violet/30 rounded-xl hover:bg-primary-violet hover:text-white group']) }}>
        <span class="material-symbols-outlined text-xl group-hover:scale-110 transition-transform">download</span>
    </button>
@endif
