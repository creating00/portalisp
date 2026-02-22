<footer
    class="border-t border-slate-200 dark:border-white/10 py-6 bg-white dark:bg-brand-dark text-slate-600 dark:text-gray-400 transition-colors duration-300">
    <div class="mx-auto max-w-7xl px-6 lg:px-10 flex flex-col md:flex-row justify-between items-center gap-6">

        {{-- Logo / Copyright --}}
        <div class="flex items-center gap-3">
            <div class="bg-primary-violet/10 dark:bg-primary-violet/20 p-1.5 rounded-lg">
                <span class="material-symbols-outlined text-primary-violet text-sm font-bold">all_inclusive</span>
            </div>
            <span class="font-extrabold tracking-tight text-slate-900 dark:text-white text-sm">
                YnfinitY © {{ date('Y') }}
            </span>
        </div>

        {{-- Links --}}
        <div class="flex gap-6 text-xs font-semibold uppercase tracking-wider">
            <a class="hover:text-primary-violet transition-colors" href="#">Privacy Policy</a>
            <a class="hover:text-primary-violet transition-colors" href="#">Terms</a>
            <a class="hover:text-primary-violet transition-colors" href="#">Support</a>
        </div>

        {{-- Redes / Social --}}
        <div class="flex gap-3">
            <div
                class="w-8 h-8 rounded-full bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 flex items-center justify-center cursor-pointer hover:bg-primary-orange hover:text-white transition-all">
                <span class="material-symbols-outlined text-base">public</span>
            </div>
            <div
                class="w-8 h-8 rounded-full bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 flex items-center justify-center cursor-pointer hover:text-white hover:bg-primary-violet transition-all">
                <span class="material-symbols-outlined text-base">alternate_email</span>
            </div>
        </div>
    </div>
</footer>
