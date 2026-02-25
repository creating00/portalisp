@props(['paginator'])

<nav class="flex justify-center items-center gap-x-1" aria-label="Pagination">
    {{-- Previous Button --}}
    <button type="button" wire:click="previousPage" {{ $paginator->onFirstPage() ? 'disabled' : '' }}
        class="min-h-9 min-w-9 py-2 px-2.5 inline-flex justify-center items-center text-sm rounded-lg text-white hover:bg-white/10 disabled:opacity-30">
        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" />
        </svg>
    </button>

    {{-- Page Numbers --}}
    <div class="flex items-center gap-x-1">
        {{-- Usamos un rango simple para evitar el error de elements() --}}
        @foreach (range(1, $paginator->lastPage()) as $page)
            <button type="button" wire:click="gotoPage({{ $page }})" @class([
                'min-h-9 min-w-9 flex justify-center items-center text-sm rounded-lg focus:outline-none',
                'border border-white/20 text-white bg-white/10' =>
                    $page == $paginator->currentPage(),
                'border border-transparent text-white/60 hover:bg-white/10' =>
                    $page != $paginator->currentPage(),
            ])>
                {{ $page }}
            </button>
        @endforeach
    </div>

    {{-- Next Button --}}
    <button type="button" wire:click="nextPage" {{ !$paginator->hasMorePages() ? 'disabled' : '' }}
        class="min-h-9 min-w-9 py-2 px-2.5 inline-flex justify-center items-center text-sm rounded-lg text-white hover:bg-white/10 disabled:opacity-30">
        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6" />
        </svg>
    </button>
</nav>
