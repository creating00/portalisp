<section class="bg-slate-50 dark:bg-white/5 py-24 border-y border-slate-200 dark:border-white/10">
    <div class="mx-auto max-w-7xl px-6 lg:px-10">
        <div class="flex flex-col gap-12">
            <div class="max-w-2xl">
                <h2 class="text-4xl font-extrabold tracking-tight mb-4">Branded for Excellence</h2>
                <p class="text-slate-600 dark:text-slate-400">Experience a portal that balances high-energy aesthetics
                    with professional grade reliability.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Feature 1 --}}
                <x-home.feature-card icon="auto_fix_high" title="Modern Design"
                    description="A violet-infused interface designed for clarity and maximum engagement."
                    color="primary-violet" />
                {{-- Feature 2 --}}
                <x-home.feature-card icon="verified_user" title="Orange-Grade Security"
                    description="Highlighting what matters most with vibrant alerts and robust authentication."
                    color="primary-orange" />
                {{-- Feature 3 --}}
                <x-home.feature-card icon="language" title="Global Branding"
                    description="YnfinitY scales with you, providing a consistent experience across the globe."
                    color="primary-violet" />
            </div>
        </div>
    </div>
</section>
