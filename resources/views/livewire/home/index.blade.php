<?php
use Livewire\Volt\Component;

new class extends Component {
    protected string $layout = 'layouts.app';
};
?>

<div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">
    {{-- <livewire:home.navbar /> --}}
    <x-home.navbar />

    <main class="flex-1">
        {{-- <x-home.hero /> --}}
        {{-- <x-home.features />
        <x-home.cta /> --}}
    </main>

    <x-home.footer />
</div>
