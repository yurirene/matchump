<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Ata;
use App\Models\Sessao;
use Illuminate\Support\Facades\Auth;

class DelegadoAtas extends Component
{
    public $atas;
    public $status;

    public function mount()
    {
        $this->loadAtas();
    }

    public function aprovarAta(Ata $ata)
    {
        $ata->aprovacaoAtas()->sync([
            auth()->user()->id => [
                'aprovado' => true,
                'tenant_id' => auth()->user()->tenant_id,
                'reuniao_id' => auth()->user()->reuniao_id,
            ]
        ]);
        session()->flash('ata-voted', 'Você aprovou a ata: ' . $ata->nome);
        $this->loadAtas();
    }

    public function reprovarAta(Ata $ata)
    {
        $ata->aprovacaoAtas()->sync([
            auth()->user()->id => [
                'aprovado' => false,
                'tenant_id' => auth()->user()->tenant_id,
                'reuniao_id' => auth()->user()->reuniao_id,
            ]
        ]);
        session()->flash('ata-voted', 'Você reprovou a ata: ' . $ata->nome);
        $this->loadAtas();
    }

    private function loadAtas()
    {
        $this->atas = Ata::with(['sessao', 'aprovacaoAtas' => function ($query) {
            $query->where('delegado_id', auth()->user()->id);
        }])->get();
        if ($this->atas->isEmpty()) {
            return;
        }
    }

    #[Layout('layouts.app-delegado')]
    public function render()
    {
        return view('livewire.delegado-atas');
    }
}