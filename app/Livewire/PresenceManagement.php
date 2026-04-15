<?php

namespace App\Livewire;

use App\Enums\TipoDelegadoEnum;
use Livewire\Component;
use App\Models\Sessao;
use App\Models\Presenca;
use App\Models\Unidade;
use Livewire\Attributes\Layout;
use App\Models\Delegado;


class PresenceManagement extends Component
{
    public Sessao $sessao;
    public $presencas;
    public $totalUnidades;

    public function mount(string $sessaoId)
    {
        $this->sessao = Sessao::with('reuniao')->findOrFail($sessaoId);
        $this->loadPresences();
        $this->totalUnidades = Unidade::count();
    }

    public function reloadDelegados()
    {
        $delegadosAtivos = Delegado::where('status', true)->get();
        
        $delegadosCadastrados = Presenca::where('sessao_id', $this->sessao->id)
            ->pluck('delegado_id')
            ->toArray();
        
        $delegadosParaCadastrar = $delegadosAtivos->filter(function ($delegado) use ($delegadosCadastrados) {
            return !in_array($delegado->id, $delegadosCadastrados);
        });
        
        $cadastrados = 0;
        foreach ($delegadosParaCadastrar as $delegado) {
            Presenca::create([
                'sessao_id' => $this->sessao->id,
                'delegado_id' => $delegado->id,
                'presente' => false,
            ]);
            $cadastrados++;
        }
        
        $this->loadPresences();
        
        if ($cadastrados > 0) {
            session()->flash('message', "{$cadastrados} delegado(s) foram adicionados à sessão com sucesso!");
        } else {
            session()->flash('message', 'Todos os delegados já estão cadastrados nesta sessão.');
        }
    }

    public function loadPresences()
    {
        // Separando delegados titulares e suplentes
        $presencas = Presenca::where('sessao_id', $this->sessao->id)
            ->with(['delegado.unidade'])
            ->get();

        $diretoria = $presencas->filter(function ($presenca) {
            return $presenca->delegado && $presenca->delegado->tipo == TipoDelegadoEnum::Diretoria;
        })->sortBy(function ($presenca) {
            return $presenca->delegado->unidade->nome ?? '';
        }, SORT_NATURAL | SORT_FLAG_CASE)->values();

        $secretarios = $presencas->filter(function ($presenca) {
            return $presenca->delegado && $presenca->delegado->tipo == TipoDelegadoEnum::Secretario;
        })->sortBy(function ($presenca) {
            return $presenca->delegado->unidade->nome ?? '';
        }, SORT_NATURAL | SORT_FLAG_CASE)->values();

        $titulares = $presencas->filter(function ($presenca) {
            return $presenca->delegado && $presenca->delegado->tipo == TipoDelegadoEnum::Delegado;
        })->sortBy(function ($presenca) {
            return $presenca->delegado->unidade->nome ?? '';
        }, SORT_NATURAL | SORT_FLAG_CASE)->values();

        $suplentes = $presencas->filter(function ($presenca) {
            return $presenca->delegado && $presenca->delegado->tipo == TipoDelegadoEnum::Suplente;
        })->sortBy(function ($presenca) {
            return $presenca->delegado->unidade->nome ?? '';
        }, SORT_NATURAL | SORT_FLAG_CASE)->values();

        $this->presencas = [
            'diretoria' => $diretoria,
            'secretarios' => $secretarios,
            'titulares' => $titulares,
            'suplentes' => $suplentes,
        ];
    }

    public function togglePresence(string $presencaId)
    {
        $presenca = Presenca::where('id', $presencaId)
            ->where('sessao_id', $this->sessao->id)
            ->firstOrFail();

        $presenca->presente = !$presenca->presente;
        $presenca->save();
        
        session()->flash('message', 'Presença atualizada com sucesso!');
        $this->loadPresences();
    }

    public function getQuorumProperty()
    {
        // Encontra todas as unidades que têm pelo menos um delegado presente
        $unidadesPresentes = collect($this->presencas)
            ->flatten(1)
            ->filter(function ($presenca) {
                return $presenca->presente && !is_null($presenca->delegado->unidade_id);
            })
            ->pluck('delegado.unidade_id')
            ->unique()
            ->count();

        // O quórum é a maioria simples: "metade + 1"
        $quorumNecessario = intval($this->totalUnidades / 2) + 1;

        return [
            'presentes' => $unidadesPresentes,
            'necessario' => (int) $quorumNecessario,
            'atingido' => $unidadesPresentes >= $quorumNecessario,
        ];
    }

    // Adiciona esta nova propriedade computada para contar os delegados presentes
    public function getDelegadosPresentesCountProperty()
    {
        // Conta o total de presenças marcadas como presentes em todas as listas
        return collect($this->presencas)
            ->flatten(1)
            ->where('presente', true)
            ->count();
    }

    
    // Adiciona esta nova propriedade computada para contar os delegados presentes
    public function getTotalDelegadosAtivosProperty()
    {
        // Conta o total de delegados do tipo "Delegado" cadastrados e ativos (status = true)
        return collect($this->presencas)
            ->flatten(1)
            ->filter(function ($presenca) {
                return $presenca->delegado
                    && $presenca->delegado->status
                    && in_array(
                        $presenca->delegado->tipo,
                        [TipoDelegadoEnum::Delegado, TipoDelegadoEnum::Diretoria, TipoDelegadoEnum::Secretario]
                    );
            })
            ->count();
    }


    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.presence-management', [
            'sessao' => $this->sessao,
        ]);
    }
}