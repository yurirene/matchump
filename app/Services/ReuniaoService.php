<?php

namespace App\Services;

class ReuniaoService
{
    public static function gerarCodigoReuniao($tenantId)
    {
        $caracteresSeguros = [
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
            '2', '3', '4', '6', '7', '8', '9'
        ];  
        
        $codigo = '';
        $tamanho = 5;
        
        for ($i = 0; $i < $tamanho; $i++) {
            $codigo .= $caracteresSeguros[array_rand($caracteresSeguros)];
        }
        
        return $codigo;
    }
}