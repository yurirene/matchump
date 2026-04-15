<?php

namespace App\Enums;

enum TipoDocumentoEnum: int
{
    case Relatorio = 1;
    case Proposta = 2;
    case Consulta = 3;
    case Substitutivo = 4;
    case RelatorioComissao = 5;
    case Outros = 6;

    public function label(): string
    {
        return match($this) {
            self::Relatorio => 'Relatório',
            self::Proposta => 'Proposta',
            self::Consulta => 'Consulta',
            self::Substitutivo => 'Substitutivo',
            self::RelatorioComissao => 'Relatório da Comissão',
            self::Outros => 'Outros',
        };
    }

    public static function forSelect()
    {
        return [
            self::Relatorio->value => self::Relatorio->label(),
            self::Proposta->value => self::Proposta->label(),
            self::Consulta->value => self::Consulta->label(),
            self::Substitutivo->value => self::Substitutivo->label(),
            self::RelatorioComissao->value => self::RelatorioComissao->label(),
            self::Outros->value => self::Outros->label(),
        ];
    }
}