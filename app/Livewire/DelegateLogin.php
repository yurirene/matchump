<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Reuniao;
use App\Models\Delegado;
use Exception;
use Livewire\Attributes\Layout;

class DelegateLogin extends Component
{
    public $codigo_reuniao = '';
    public $cpf = '';

    protected $rules = [
        'codigo_reuniao' => 'required|string|max:5',
        'cpf' => 'required|string|max:14',
    ];

    public function mount()
    {
        if (Auth::guard('delegados')->check()) {
            return redirect()->route('area-delegado.home');
        }
    }

    public function login()
    {
        if (Auth::guard('delegados')->check()) {
            return redirect()->route('area-delegado.home');
        }

        $this->validate();

        $cpf = preg_replace('/[^0-9]/', '', $this->cpf);
        $reuniao = Reuniao::where('codigo', $this->codigo_reuniao)->first();

        if (!$reuniao) {
            Auth::guard('delegados')->logout();
            session()->flash('error', 'Código da reunião inválido ou delegado não vinculado.');
            return;
        }
        
        $delegado = Delegado::withoutGlobalScopes(['reuniao_ativa', 'tenant'])
            ->where('cpf', $cpf)
            ->where('reuniao_id', $reuniao->id)
            ->first();

        if (!$delegado) {
            Auth::guard('delegados')->logout();
            session()->flash('error', 'Delegado ou Reunião não encontrada.');
            return;
        }


        if ($delegado->reuniao_id !== $reuniao->id) {
            Auth::guard('delegados')->logout();
            session()->flash('error', 'Delegado não está vinculado a esta reunião.');
            return;
        }

        Auth::guard('delegados')->login($delegado);
        session(['selectedReuniaoId' => $reuniao->id]);

        return redirect()->route('area-delegado.home');
    }

    #[Layout('layouts.app-delegado')]
    public function render()
    {
        return view('livewire.delegate-login');
    }
}