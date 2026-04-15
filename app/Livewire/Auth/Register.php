<?php

namespace App\Livewire\Auth;

use App\Services\ExternalApiService;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Livewire\Attributes\Layout;

class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $tenant_id = '';

    public function register()
    {
        $creator = app(CreatesNewUsers::class);

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'tenant_id' => ['required', 'uuid', 'unique:users'],
        ]);

        $key = 'register_attempts_' . request()->ip();
        $attempts = cache()->get($key, 0);
        $maxAttempts = 3;
        $decay = now()->addMinutes(1);

        if ($attempts >= $maxAttempts) {
            throw ValidationException::withMessages([
                'email' => 'Muitas tentativas. Tente novamente em 5 minutos.'
            ]);
        }

        cache()->put($key, $attempts + 1, $decay);

        $apiService = new ExternalApiService();
        $validToken = $apiService->validarToken($this->tenant_id);
        if (!$validToken) {
            throw ValidationException::withMessages([
                'tenant_id' => 'Token inválido',
            ]);
        }

        $sinodal = $apiService->isSinodal($this->tenant_id);

        $user = $creator->create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
            'tenant_id' => $this->tenant_id,
            'sinodal' => $sinodal,
        ]);

        Auth::login($user);

        return redirect()->intended(config('fortify.home'));
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.auth.register');
    }
}