<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DelegadoLogout extends Component
{
    public function logout()
    {
        Auth::guard('delegados')->logout();

        return redirect()->route('delegado.login');
    }

    public function render()
    {
        return view('livewire.delegado-logout');
    }
}