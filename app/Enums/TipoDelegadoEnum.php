<?php

namespace App\Enums;

enum TipoDelegadoEnum: int
{
    case Delegado = 1;
    case Suplente = 2;
    case Diretoria = 3;
    case Secretario = 4;
    public function label()
    {
        return match ($this) {
            self::Delegado => 'Delegado',
            self::Suplente => 'Suplente',
            self::Diretoria => 'Diretoria',
            self::Secretario => 'Secretário(a)',
        };
    }

    public static function forSelect()
    {
        return [
            self::Delegado->value => self::Delegado->label(),
            self::Suplente->value => self::Suplente->label(),
            self::Diretoria->value => self::Diretoria->label(),
            self::Secretario->value => self::Secretario->label(),
        ];
    }
}
