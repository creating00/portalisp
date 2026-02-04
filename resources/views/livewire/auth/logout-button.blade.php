<?php
use Livewire\Volt\Component;

new class extends Component {
    public function logout()
    {
        session()->forget(['api_token', 'cliente']);

        return redirect()->to('/');
    }
};
?>

<button wire:click="logout" wire:loading.attr="disabled" wire:target="logout"
    class="flex w-full items-center px-4 py-2 text-sm text-red-400 hover:bg-white/5 transition-colors disabled:opacity-50">

    <span wire:loading.remove wire:target="logout" class="material-symbols-outlined mr-2">logout</span>

    <span wire:loading wire:target="logout" class="material-symbols-outlined mr-2 animate-spin">progress_activity</span>

    <span wire:loading.remove wire:target="logout">Logout</span>
    <span wire:loading wire:target="logout">Closing session…</span>
</button>
