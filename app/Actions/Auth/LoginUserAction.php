<?php

namespace App\Actions\Auth;

use App\Services\IspApiService;
use Illuminate\Validation\ValidationException;

class LoginUserAction
{
    public function execute(IspApiService $api, string $email, string $password): void
    {
        $response = $api->login($email, $password);

        if (!$response->successful()) {
            // Captura "Credenciales inválidas" o cualquier error de la API
            $error = $response->json('error') ?? 'Las credenciales no coinciden.';

            throw ValidationException::withMessages([
                'email' => $error,
            ]);
        }

        $token = $response->json('token');
        session(['api_token' => $token]);

        /** @var Response $resCliente */
        $resCliente = $api->getCliente($token);

        if ($resCliente->successful()) {
            $data = $resCliente->json();
            session([
                'cliente' => [
                    'id'       => $data['id'],
                    'dni'      => $data['dni'],
                    'nombre'   => $data['nombre'],
                    'apellido' => $data['apellido'],
                    'email'    => $data['mail'],
                ],
            ]);
        }
    }
}
