<?php

namespace App\Enums;

enum InscripcionEstado: string
{
    case ACTIVA = 'activa';
    case COMPLETADA = 'completada';
    case CANCELADA = 'cancelada';

    public function label(): string
    {
        return match($this) {
            self::ACTIVA => 'Activa',
            self::COMPLETADA => 'Completada',
            self::CANCELADA => 'Cancelada',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::ACTIVA => 'success',
            self::COMPLETADA => 'primary',
            self::CANCELADA => 'danger',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::ACTIVA => '✓',
            self::COMPLETADA => '✓✓',
            self::CANCELADA => '✗',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(function ($case) {
            return [$case->value => $case->label()];
        })->toArray();
    }
}
