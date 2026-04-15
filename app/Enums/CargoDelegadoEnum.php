<?php

namespace App\Enums;

enum CargoDelegadoEnum: int
{
    case Diacono = 1;
    case Presbitero = 2;

    public function label()
    {
        return match ($this) {
            self::Diacono => 'Diácono',
            self::Presbitero => 'Presbítero',
        };
    }

    public static function forSelect()
    {
        return [
            self::Diacono->value => self::Diacono->label(),
            self::Presbitero->value => self::Presbitero->label(),
        ];
    }
}
