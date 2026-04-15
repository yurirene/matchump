<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Models\Comissao;
use App\Models\Documento;

class DelegadoComissoes extends Component
{
    public $comissoes;
    public $reuniaoId;
    public $relator;
    public $documentosDaComissao;
    public $documentosProduzidos;

    public function mount()
    {
        // Obtém o delegado autenticado
        $delegado = Auth::guard('delegados')->user();
        $this->reuniaoId = session('selectedReuniaoId');

        if (!$delegado || !$this->reuniaoId) {
            session()->flash('error', 'Por favor, selecione uma reunião para ver as comissões.');
            $this->comissoes = collect();
            return;
        }

        // Busca todas as comissões do delegado para a reunião ativa
        $this->comissoes = $delegado->comissoes()
            ->with(['documentos']) // Carrega o relator e os documentos
            ->get();

        foreach ($this->comissoes as $comissao) {
            $this->relator[$comissao->id] = $comissao->relator();
        }

        foreach ($this->comissoes as $comissao) {
            $this->documentosDaComissao[$comissao->id] = $comissao->documentos;
            $this->documentosProduzidos[$comissao->id] = Documento::where('comissao_id', $comissao->id)->get();
        }
    }

    #[Layout('layouts.app-delegado')]
    public function render()
    {
        return view('livewire.delegado-comissoes');
    }
}