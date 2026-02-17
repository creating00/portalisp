<?php

namespace App\Actions\Auth;

use App\Services\IspApiService;
use Illuminate\Http\Client\Response;
use Illuminate\Validation\ValidationException;

class RegisterUserAction
{
    public function execute(IspApiService $api, array $data): bool
    {
        /** @var \Illuminate\Http\Client\Response $response */
        $response = $api->register($data);

        if (!$response->successful()) {
            // Extraemos el error del JSON o usamos uno por defecto
            $errorMessage = $response->json('error') ?? $response->json('message') ?? 'Error en el registro.';

            throw ValidationException::withMessages([
                'dni' => $errorMessage
            ]);
        }

        $token = $response->json('token');
        session(['api_token' => $token]);

        /** @var Response $resCliente */
        $resCliente = $api->getCliente($token);
        if ($resCliente->successful()) {
            session(['cliente' => $this->mapCliente($resCliente->json())]);
        }
        return true;
    }

    private function mapCliente(array $data): array
    {
        return [
            'id'       => $data['id'],
            'dni'      => $data['dni'],
            'nombre'   => $data['nombre'],
            'apellido' => $data['apellido'],
            'email'    => $data['mail'],
        ];
    }
}
