<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Response;

class IspApiService
{
    protected string $baseUrl;
    protected string $authPrefix;
    protected string $systemPrefix;

    public function __construct()
    {
        $this->baseUrl = env('ISP_CENTRAL_URL', 'http://localhost/isp');
        $this->authPrefix = '/api/auth';
        $this->systemPrefix = '/system/api';
    }

    public function register(array $data)
    {
        return Http::withHeaders(['Accept' => 'application/json'])
            ->post("{$this->baseUrl}{$this->authPrefix}/register", $data);
    }

    public function login(string $email, string $password)
    {
        return Http::withHeaders(['Accept' => 'application/json'])
            ->post("{$this->baseUrl}{$this->authPrefix}/login", [
                'email' => $email,
                'password' => $password
            ]);
    }

    public function getCliente(string $token)
    {
        return Http::withToken($token)
            ->withHeaders(['Accept' => 'application/json'])
            ->get("{$this->baseUrl}{$this->systemPrefix}/cliente");
    }

    public function getContratos(string $token, string $dni)
    {
        return Http::withToken($token)
            ->get("{$this->baseUrl}{$this->systemPrefix}/cliente/contratos", [
                'dni' => $dni
            ]);
    }

    public function getFacturas(string $token, int $contratoId)
    {
        return Http::withToken($token)
            ->get("{$this->baseUrl}{$this->systemPrefix}/cliente/facturas", [
                'contratoId' => $contratoId
            ]);
    }

    public function getMercadoPagoPreference(string $token, int $facturaId): Response
    {
        /** @var Response $response */
        $response = Http::withToken($token)
            ->withoutVerifying()
            ->timeout(20)
            ->withHeaders(['Accept' => 'application/json'])
            ->post("{$this->baseUrl}{$this->systemPrefix}/pagos/mercado-pago/preferencia", [
                'factura_id' => $facturaId
            ]);

        return $response;
    }

    public function subirComprobante(string $token, int $facturaId, $file, ?string $observaciones = null, float $monto = 0)
    {
        return Http::withToken($token)
            ->asMultipart()
            ->attach(
                'comprobante',
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            )
            ->post("{$this->baseUrl}{$this->systemPrefix}/pagos", [
                'factura_id' => $facturaId,
                'montoPagado' => $monto, // Ahora enviamos el monto de la factura
                'metodoPago' => 'transferencia',
                'observaciones' => $observaciones,
                'esPagoExterno' => 'true' // Enviado como string para multipart
            ]);
    }

    public function confirmarPagoMercadoPago(string $token, array $datos)
    {
        return Http::withToken($token)
            ->withoutVerifying()
            ->withHeaders(['Accept' => 'application/json'])
            ->post("{$this->baseUrl}{$this->systemPrefix}/pagos", [
                'factura_id'    => (int)$datos['factura_id'],
                'montoPagado'   => (float)$datos['monto'],
                'metodoPago'    => 'mercado_pago',
                'mp_payment_id' => $datos['payment_id'],
                'mp_preference_id' => $datos['preference_id'],
                'esPagoExterno' => true
            ]);
    }
}
