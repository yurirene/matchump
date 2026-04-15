<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Models\Delegado;
use App\Models\Documento;
use App\Models\Comissao;
use App\Models\Sessao;

class DelegadoHome extends Component
{
    public $delegado;
    public $sessaoAtiva;

    public function mount()
    {
        $this->delegado = Auth::guard('delegados')->user();

        if (!$this->delegado) {
            return redirect()->route('login.delegados');
        }

        $reuniaoId = session('selectedReuniaoId');

        $this->sessaoAtiva = Sessao::withoutGlobalScopes(['reuniao_ativa', 'tenant'])
            ->where('reuniao_id', $reuniaoId)
            ->where('tenant_id', $this->delegado->tenant_id)
            ->first();
    }

    #[Layout('layouts.app-delegado')]
    public function render()
    {
        return view('livewire.delegado-home');
    }
}