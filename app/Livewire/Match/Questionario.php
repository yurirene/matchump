<?php

namespace App\Livewire\Match;

use App\Models\MatchResposta;
use App\Models\Pergunta;
use App\Support\MatchQuestionCategoria;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.match')]
#[Title('Questionário')]
class Questionario extends Component
{
    /** @var array<int, string> pergunta_id => alternativa */
    public array $answers = [];

    public int $step = 0;

    public function mount(): void
    {
        $user = Auth::guard('match')->user();
        foreach ($user->respostas as $r) {
            $this->answers[$r->pergunta_id] = $r->alternativa;
        }
    }

    public function getPerguntasProperty()
    {
        return Pergunta::query()->orderBy('ordem')->get();
    }

    public function saveCurrent(): void
    {
        $user = Auth::guard('match')->user();
        $perguntas = $this->perguntas;
        $atual = $perguntas[$this->step] ?? null;
        if (! $atual) {
            return;
        }

        $letter = $this->answers[$atual->id] ?? null;
        if (! $letter) {
            $this->addError('answers', 'Selecione uma opção.');

            return;
        }

        MatchResposta::query()->updateOrCreate(
            [
                'match_user_id' => $user->id,
                'pergunta_id' => $atual->id,
            ],
            [
                'alternativa' => strtoupper($letter),
            ]
        );

        $this->resetErrorBag();

        if ($this->step >= $this->perguntas->count() - 1) {
            session()->flash('status', 'Questionário salvo com sucesso.');
            $this->redirect(route('match.perfil'), navigate: true);
        }
    }

    public function next(): void
    {
        $this->saveCurrent();
        if ($this->getErrorBag()->isNotEmpty()) {
            return;
        }
        $max = $this->perguntas->count() - 1;
        if ($this->step < $max) {
            $this->step++;
        }
    }

    public function previous(): void
    {
        if ($this->step > 0) {
            $this->step--;
        }
    }

    public function goToStep(int $index): void
    {
        if ($index >= 0 && $index < $this->perguntas->count()) {
            $this->step = $index;
        }
    }

    public function render()
    {
        $perguntas = $this->perguntas;
        $total = max(1, $perguntas->count());
        $atual = $perguntas[$this->step] ?? null;
        $progress = (int) round((($this->step + 1) / $total) * 100);

        return view('livewire.match.questionario', [
            'perguntas' => $perguntas,
            'atual' => $atual,
            'total' => $total,
            'progress' => $progress,
            'categoriaAtual' => $atual ? MatchQuestionCategoria::label((int) $atual->ordem) : '',
        ]);
    }
}
