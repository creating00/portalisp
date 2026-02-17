<?php

namespace App\Services;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;

class MercadoPagoService
{
    /**
     * Configura el token antes de cada operación.
     */
    private function setToken(string $token): void
    {
        MercadoPagoConfig::setAccessToken($token);
    }

    public function crearPreferencia(array $itemData, string $token, int $facturaId)
    {
        $this->setToken($token);
        $client = new PreferenceClient();

        return $client->create([
            "items" => [$itemData],
            "external_reference" => (string) $facturaId, // Vital para el Webhook
            "back_urls" => [
                "success" => route('pago.exitoso'),
                "failure" => route('pago.fallido'),
                "pending" => route('pago.pendiente')
            ],
            "auto_return" => "approved",
            // El webhook debe apuntar al SISTEMA CENTRAL (donde está la lógica de facturación)
            "notification_url" => "https://tu-dominio-central.com/api/pagos/webhook_mp.php"
        ]);
    }
}
