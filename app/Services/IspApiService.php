<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class IspApiService
{
    protected string $baseUrl;
    protected string $authPrefix;
    protected string $systemPrefix;

    public function __construct()
    {
        $this->baseUrl = 'http://localhost/isp';
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
}
