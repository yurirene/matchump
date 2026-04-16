<?php

namespace App\Livewire\Match;

use App\Models\Pergunta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.match')]
#[Title('Entrar')]
class Login extends Component
{
    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    public function login(): void
    {
        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('match')->attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            throw ValidationException::withMessages([
                'email' => __('Credenciais inválidas.'),
            ]);
        }

        session()->regenerate();

        $user = Auth::guard('match')->user();
        $total = Pergunta::query()->count();
        $feito = $total > 0 && $user->respostas()->count() >= $total;
        $destino = $feito ? route('match.perfil') : route('match.questionario');

        $this->redirect($destino, navigate: true);
    }

    public function render()
    {
        return view('livewire.login');
    }
}
