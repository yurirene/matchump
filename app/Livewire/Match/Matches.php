<?php

namespace App\Livewire\Match;

use App\Services\MatchService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.match')]
#[Title('Matches')]
class Matches extends Component
{
    public string $ordenacao = 'compatibilidade';

    public function render(MatchService $matchService)
    {
        $user = Auth::guard('match')->user();
        $lista = $matchService->candidatosPara($user);

        if ($this->ordenacao === 'idade') {
            usort($lista, fn ($a, $b) => $a['user']->age() <=> $b['user']->age());
        } elseif ($this->ordenacao === 'nome') {
            usort($lista, fn ($a, $b) => strcmp($a['user']->name, $b['user']->name));
        }

        return view('livewire.match.matches', [
            'lista' => $lista,
        ]);
    }
}
