<?php

namespace App\Livewire\Match;

use App\Models\Pergunta;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.match')]
#[Title('Início')]
class Dashboard extends Component
{
    public function render()
    {
        $user = Auth::guard('match')->user();
        $totalPerguntas = Pergunta::query()->count();
        $respondidas = $user->respostas()->count();
        $completo = $totalPerguntas > 0 && $respondidas >= $totalPerguntas;

        return view('livewire.match.dashboard', [
            'user' => $user,
            'totalPerguntas' => $totalPerguntas,
            'respondidas' => $respondidas,
            'completo' => $completo,
        ]);
    }
}
