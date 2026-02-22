<?php

namespace App\DTOs;

use Illuminate\Http\UploadedFile;

class SubirComprobanteDTO
{
    public function __construct(
        public int $facturaId,
        public UploadedFile $file,
        public float $monto = 0,
        public ?string $observaciones = null,
        public bool $enviarExcedente = false,
        public bool $usarSaldoMonedero = false
    ) {}
}
