@props(['title', 'subtitle', 'isDark' => false])

<div class="flex items-center gap-3 mb-12">
    <a href="/" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
        <div class="bg-primary-violet p-2 rounded-xl shadow-lg shadow-primary-violet/20">
            <span class="material-symbols-outlined text-white font-bold text-2xl">all_inclusive</span>
        </div>
        <h2
            class="text-3xl font-extrabold tracking-tighter bg-clip-text text-transparent bg-gradient-to-r from-primary-violet to-primary-orange">
            YnfinitY
        </h2>
    </a>
</div>

<div class="mb-10">
    <h1 class="text-4xl font-extrabold mb-2 {{ $isDark ? 'text-white' : 'text-slate-900' }}">
        {{ $title }}
    </h1>
    <p class="font-medium {{ $isDark ? 'text-slate-400' : 'text-slate-500' }}">
        {{ $subtitle }}
    </p>
</div>
