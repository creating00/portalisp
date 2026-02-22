<?php

namespace App\Services;

use App\DTOs\SubirComprobanteDTO;
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

    public function register(array $data): Response
    {
        /** @var Response $response */
        $response = Http::withHeaders(['Accept' => 'application/json'])
            ->post("{$this->baseUrl}{$this->authPrefix}/register", $data);

        return $response;
    }

    public function login(string $email, string $password): Response
    {
        $response = Http::withHeaders(['Accept' => 'application/json'])
            ->post("{$this->baseUrl}{$this->authPrefix}/login", [
                'email' => $email,
                'password' => $password
            ]);

        /** @var Response $response */
        return $response;
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

    public function checkMercadoPagoConfig(string $token, int $facturaId): Response
    {
        /** @var Response $response */
        $response = Http::withToken($token)
            ->withoutVerifying()
            ->timeout(10) // Evita esperas infinitas en el bucle
            ->withHeaders(['Accept' => 'application/json'])
            ->post("{$this->baseUrl}{$this->systemPrefix}/pagos/mercado-pago/check-config", [
                'factura_id' => $facturaId
            ]);

        if ($response->failed()) {
            Log::warning("Fallo check-config MP para factura {$facturaId}: " . $response->body());
        }

        return $response;
    }

    public function subirComprobante(string $token, SubirComprobanteDTO $dto)
    {
        return Http::withToken($token)
            ->asMultipart()
            ->attach(
                'comprobante',
                file_get_contents($dto->file->getRealPath()),
                $dto->file->getClientOriginalName()
            )
            ->post("{$this->baseUrl}{$this->systemPrefix}/pagos", [
                'factura_id'    => $dto->facturaId,
                'montoPagado'   => $dto->monto,
                'metodoPago'    => 'transferencia',
                'observaciones' => $dto->observaciones,
                'esPagoExterno' => 'true',
                'enviarExcedenteAMonedero' => $dto->enviarExcedente ? 'true' : 'false',
                'usarSaldoMonedero'       => $dto->usarSaldoMonedero ? 'true' : 'false'
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

    public function changePassword(string $token, string $currentPassword, string $newPassword): Response
    {
        /** @var Response $response */
        $response = Http::withToken($token)
            ->withHeaders(['Accept' => 'application/json'])
            ->post("{$this->baseUrl}{$this->systemPrefix}/cliente/password", [
                'current_password' => $currentPassword,
                'password' => $newPassword,
                'password_confirmation' => $newPassword,
            ]);

        return $response;
    }
}
