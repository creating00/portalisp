{{-- Profile link backup --}}
<x-nav.dropdown-item href="/profile" icon="person">
    Profile
</x-nav.dropdown-item>

{{-- Products dropdown backup --}}
<x-nav.dropdown label="Products">
    <x-nav.dropdown-header label="Essentials" />
    <x-nav.dropdown-item href="#" icon="dashboard">UI Kits</x-nav.dropdown-item>
    <x-nav.dropdown-item href="#" icon="auto_awesome">Templates</x-nav.dropdown-item>

    <hr class="border-white/5 my-2 mx-2">

    <x-nav.dropdown-header label="Premium Content" />
    <x-nav.dropdown-item href="#" special="true" icon="star">
        Exclusive Assets
    </x-nav.dropdown-item>
    <x-nav.dropdown-item href="#" icon="diamond">YnfinitY Pro</x-nav.dropdown-item>
</x-nav.dropdown>

{{-- Auth links backup --}}
@authsession
<x-nav.link href="#">Features</x-nav.link>
<x-nav.link href="#">Pricing</x-nav.link>
@endauthsession
