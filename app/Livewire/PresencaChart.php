<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Delegado;
use App\Models\Reuniao;
use App\Models\Sessao;
use App\Models\Presenca;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class PresencaChart extends Component
{
    public $reuniao;
    public $totalDelegados = 0;
    public $presentesCount = 0;
    public $ausentesCount = 0;
    public $quorum = 0;
    public $metadeQuorum = 0;
    public $temQuorum = false;
    public $sessao;

    public function mount()
    {
        $reuniaoId = session('selectedReuniaoId');
        
        if ($reuniaoId) {
            $this->reuniao = Reuniao::find($reuniaoId);
            
            $this->totalDelegados = Delegado::count();
            $this->sessao = Sessao::where('status', true)->first();

            $this->presentesCount = Presenca::where('sessao_id', $this->sessao->id)
                ->where('presente', true)
                ->count();

            $this->ausentesCount = $this->totalDelegados - $this->presentesCount;
            
            $this->metadeQuorum = floor($this->totalDelegados / 2) + 1;
            $this->temQuorum = $this->presentesCount >= $this->metadeQuorum;

        } else {
            session()->flash('reuniao-error', 'Nenhuma reunião ativa selecionada.');
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $chartData = [
            'presentes' => $this->presentesCount,
            'ausentes' => $this->ausentesCount
        ];

        return view('livewire.presenca-chart', [
            'chartData' => json_encode($chartData),
        ]);
    }
}