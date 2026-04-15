<?php

namespace App\Enums;

enum CalificacionTipo: string
{
    case PARCIAL_1 = 'Parcial 1';
    case PARCIAL_2 = 'Parcial 2';
    case PARCIAL_3 = 'Parcial 3';
    case FINAL = 'Final';
    case TRABAJO_PRACTICO = 'Trabajo Práctico';

    public function label(): string
    {
        return match($this) {
            self::PARCIAL_1 => 'Parcial 1',
            self::PARCIAL_2 => 'Parcial 2',
            self::PARCIAL_3 => 'Parcial 3',
            self::FINAL => 'Final',
            self::TRABAJO_PRACTICO => 'Trabajo Práctico',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(function ($case) {
            return [$case->value => $case->label()];
        })->toArray();
    }
}
