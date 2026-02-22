<x-app-layout>
    <x-pago-status type="error" icon="error" title="Pago Fallido" buttonText="Intentar nuevamente" :buttonLink="route('contracts.index')">
        No pudimos procesar la transacción. No se ha realizado ningún cargo a tu cuenta.

        <x-slot:footer>
            <span class="text-sm text-gray-500 dark:text-gray-500">
                O ponte en contacto con soporte técnico.
            </span>
        </x-slot:footer>
    </x-pago-status>
</x-app-layout>
