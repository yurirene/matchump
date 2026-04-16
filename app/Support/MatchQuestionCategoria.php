<?php

namespace App\Support;

/**
 * Abas do comparativo de respostas (questionário refinado, 20 itens).
 */
final class MatchQuestionCategoria
{
    public static function label(int $ordem): string
    {
        return match (true) {
            in_array($ordem, [4, 5, 6, 7, 13, 14, 20], true) => 'Fé, valores e metas',
            in_array($ordem, [1, 2, 3, 8, 9, 10, 18], true) => 'Convívio e personalidade',
            in_array($ordem, [11, 12, 15, 16, 17, 19], true) => 'Rotina, igreja e comunicação',
            default => 'Outras',
        };
    }

    public static function slug(int $ordem): string
    {
        return match (true) {
            in_array($ordem, [4, 5, 6, 7, 13, 14, 20], true) => 'valores',
            in_array($ordem, [1, 2, 3, 8, 9, 10, 18], true) => 'personalidade',
            in_array($ordem, [11, 12, 15, 16, 17, 19], true) => 'estilo',
            default => 'outros',
        };
    }
}
