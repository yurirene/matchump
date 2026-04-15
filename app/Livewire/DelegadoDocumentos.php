<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Documento;
use Illuminate\Support\Facades\Auth;

class DelegadoDocumentos extends Component
{
    public $documentos;
    public $reuniaoId;

    public function mount()
    {
        $this->reuniaoId = session('selectedReuniaoId');

        if (!$this->reuniaoId) {
            session()->flash('reuniao-error', 'Nenhuma reunião ativa selecionada. Por favor, selecione uma para ver os documentos.');
            $this->documentos = collect();
            return;
        }

        $this->documentos = Documento::where('reuniao_id', $this->reuniaoId)
            ->where('tenant_id', Auth::user()->tenant_id)
            ->orderBy('numero', 'asc')
            ->get();
    }

    #[Layout('layouts.app-delegado')]
    public function render()
    {
        return view('livewire.delegado-documentos');
    }
}