<?php

namespace App\Services;

use App\Models\Delegado;
use App\Models\Presenca;
use App\Models\Sessao;

class SessaoService
{
    public function createSessao(string $nome)
    {
        $this->encerrarSessoesAtivas();
        
        $sessao = Sessao::create([
            'nome' => $nome,
        ]);

        // Encontra todos os delegados ativos
        $delegadosAtivos = Delegado::where('status', true)
            ->get();

        // Cria os registros de presença
        $presencas = $delegadosAtivos->map(function ($delegado) use ($sessao) {
            Presenca::create([
                'delegado_id' => $delegado->id,
                'sessao_id' => $sessao->id,
                'presente' => false,
            ]);
        })->toArray();
    }

    public function updateSessao(string $id, string $nome)
    {
        $sessao = Sessao::find($id);
        $sessao->update([
            'nome' => $nome,
        ]);
    }

    public function encerrarSessoesAtivas()
    {
        Sessao::where('status', true)->update(['status' => false]);
    }
}