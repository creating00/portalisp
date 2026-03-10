<?php

namespace App\Enums;

enum StatusType: string
{
    case ACTIVO = 'activo';
    case SUSPENDIDO = 'suspendido';
    case BAJA = 'baja';
    case PAGADO = 'pagado';
    case PENDIENTE = 'pendiente';
    case VENCIDO = 'vencido';
    case REVISION = 'revision';

    public function label(): string
    {
        return match ($this) {
            self::REVISION => 'En Revisión',
            default => ucfirst($this->value),
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::ACTIVO => 'check_circle',
            self::SUSPENDIDO => 'pause_circle',
            self::BAJA => 'cancel',
            self::PAGADO => 'verified',
            self::PENDIENTE => 'schedule',
            self::VENCIDO => 'priority_high',
            self::REVISION => 'visibility',
        };
    }

    public function colorClasses(): string
    {
        return match ($this) {
            self::ACTIVO => 'bg-green-500/10 text-green-400 border-green-500/20',
            self::SUSPENDIDO => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
            self::BAJA => 'bg-red-500/10 text-red-400 border-red-500/20',
            self::PAGADO => 'bg-emerald-500/15 text-emerald-400 border-emerald-500/30',
            self::PENDIENTE => 'bg-orange-500/15 text-orange-400 border-orange-500/30',
            self::VENCIDO => 'bg-red-500/15 text-red-400 border-red-500/30',
            self::REVISION => 'bg-indigo-500/15 text-indigo-400 border-indigo-500/30',
        };
    }

    public function puedePagar(): bool
    {
        return match ($this) {
            self::PENDIENTE, self::VENCIDO => true,
            default => false, // revision, pagado, etc. no permiten pagar
        };
    }
}
