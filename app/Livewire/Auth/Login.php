<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Http\Responses\LoginResponse;
use Livewire\Attributes\Layout;

class Login extends Component
{
    public $email;
    public $password;
    public $remember = false;

    public function mount()
    {
        // Redireciona se o usuário já estiver logado
        if (Auth::check()) {
            return redirect()->intended(config('fortify.home'));
        }
    }

    public function authenticate()
    {
        $this->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        return app(LoginResponse::class);
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.auth.login');
    }
}