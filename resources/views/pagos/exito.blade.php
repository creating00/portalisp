<x-app-layout>
    <x-pago-status type="success" icon="check_circle" title="¡Pago Recibido!" buttonText="Ir a mis Contratos"
        :buttonLink="route('contracts.index')" :redirect="route('contracts.index')">
        Tu comprobante ha sido procesado. En unos instantes verás reflejado el cambio en tu estado de cuenta.
    </x-pago-status>
</x-app-layout>
