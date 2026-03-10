<?php

namespace App\Http\Controllers;

use App\Services\IspApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PagoController extends Controller
{
    protected $ispApi;

    public function __construct(IspApiService $ispApi)
    {
        $this->ispApi = $ispApi;
    }

    /**
     * Este es el método que debe llamar tu JS
     */
    public function generarPreferencia(Request $request)
    {
        $facturaId = $request->input('factura_id');
        $token = session('api_token');

        if (!$token) {
            return response()->json(['error' => 'Sesión no válida'], 401);
        }

        try {
            $response = $this->ispApi->getMercadoPagoPreference($token, (int)$facturaId);

            if ($response->failed()) {
                Log::error("Error Central MP [Factura #$facturaId]: " . $response->body());
                $data = $response->json();
                return response()->json([
                    'error' => $data['error'] ?? 'Error en el servidor central'
                ], $response->status());
            }

            $data = $response->json();

            // Retornamos todo lo necesario al JS para la redirección
            return response()->json([
                'preferenceId'       => $data['preferenceId'] ?? null,
                'publicKey'          => $data['publicKey'] ?? null,
                'init_point'         => $data['init_point'] ?? null,
                'sandbox_init_point' => $data['sandbox_init_point'] ?? null,
                'monto'              => $data['monto'] ?? 0
            ]);
        } catch (\Exception $e) {
            Log::critical("Excepción en generarPreferencia: " . $e->getMessage());
            return response()->json(['error' => 'Error de conexión con el servidor'], 500);
        }
    }

    public function checkDisponibilidad(Request $request)
    {
        $token = session('api_token');
        if (!$token) return response()->json(['status' => false], 401);

        try {
            $response = $this->ispApi->checkMercadoPagoConfig($token, (int)$request->factura_id);

            if ($response->successful() && $response->json('disponible')) {
                return response()->json(['status' => true]);
            }
        } catch (\Exception $e) {
            Log::error("Error checkDisponibilidad: " . $e->getMessage());
        }

        return response()->json(['status' => false, 'message' => 'Mercado Pago no disponible']);
    }

    public function exito(Request $request)
    {
        // 1. Log inmediato para ver si entra
        Log::info("¡Entró a la ruta de éxito!", $request->all());

        $token = session('api_token');

        // 2. Mapeamos los datos de la URL que pasaste
        $datos = [
            'factura_id'    => $request->query('external_reference'), // 102
            'payment_id'    => $request->query('payment_id'),         // 145180299149
            'preference_id' => $request->query('preference_id'),      // 3198541540-5740...
            'monto'         => 0, // El central lo resuelve
        ];

        // 3. Enviamos al Central
        /** @var \Illuminate\Http\Client\Response $response */
        $response = $this->ispApi->confirmarPagoMercadoPago($token, $datos);

        if ($response->successful()) {
            return view('pagos.exito');
        }

        Log::error("Error Central: " . $response->body());
        return view('pagos.error');
    }

    public function fallido()
    {
        return view('pagos.fallido');
    }
}
