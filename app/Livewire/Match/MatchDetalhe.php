<?php

namespace App\Livewire\Match;

use App\Models\MatchUser;
use App\Models\Pergunta;
use App\Services\MatchService;
use App\Support\MatchQuestionCategoria;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.match')]
#[Title('Compatibilidade')]
class MatchDetalhe extends Component
{
    public MatchUser $alvo;

    public string $aba = 'valores';

    public function mount(MatchUser $alvo): void
    {
        $this->alvo = $alvo;

        if ($this->alvo->id === Auth::guard('match')->id()) {
            $this->redirect(route('match.perfil'), navigate: true);
        }
    }

    public function render(MatchService $matchService)
    {
        $viewer = Auth::guard('match')->user();
        $resultado = $matchService->calcularMatch($viewer, $this->alvo);

        $perguntas = Pergunta::query()->orderBy('ordem')->get();
        $respViewer = $viewer->respostas()->pluck('alternativa', 'pergunta_id');
        $respAlvo = $this->alvo->respostas()->pluck('alternativa', 'pergunta_id');

        $comparacoes = $perguntas->map(function (Pergunta $p) use ($respViewer, $respAlvo) {
            $lv = strtoupper((string) $respViewer->get($p->id, ''));
            $la = strtoupper((string) $respAlvo->get($p->id, ''));
            $op = $p->opcoes ?? [];

            return [
                'ordem' => $p->ordem,
                'slug' => MatchQuestionCategoria::slug((int) $p->ordem),
                'categoria' => MatchQuestionCategoria::label((int) $p->ordem),
                'texto' => $p->texto,
                'viewer_alt' => $lv,
                'alvo_alt' => $la,
                'viewer_label' => $op[$lv] ?? '—',
                'alvo_label' => $op[$la] ?? '—',
                'igual' => $lv !== '' && $lv === $la,
            ];
        });

        return view('livewire.match.match-detalhe', [
            'resultado' => $resultado,
            'comparacoes' => $comparacoes,
            'viewer' => $viewer,
        ]);
    }

}
