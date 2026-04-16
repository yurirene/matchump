<?php

namespace App\Livewire\Match;

use App\Models\MatchUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.match')]
#[Title('Cadastro')]
class Register extends Component
{
    use WithFileUploads;

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public string $birth_date = '';

    public string $sexo = '';

    public $avatar = null;

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:match_users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'birth_date' => [
                'required',
                'date',
                'after_or_equal:'.now()->subYears(35)->format('Y-m-d'),
                'before_or_equal:'.now()->subYears(21)->format('Y-m-d'),
            ],
            'sexo' => ['required', 'string', 'in:masculino,feminino'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ], [
            'birth_date.after_or_equal' => 'A idade deve ser no máximo 35 anos.',
            'birth_date.before_or_equal' => 'A idade deve ser pelo menos 21 anos.',
        ]);

        $upload = $validated['avatar'] ?? $this->avatar;
        $path = null;
        if ($upload) {
            $stored = Storage::disk('public')->putFile('avatars', $upload);
            if ($stored !== false) {
                $path = $stored;
            }
        }

        $user = MatchUser::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'birth_date' => $validated['birth_date'],
            'sexo' => $validated['sexo'],
            'avatar_path' => $path,
        ]);

        Auth::guard('match')->login($user);

        $this->redirect(route('match.questionario'), navigate: true);
    }

    public function render()
    {
        return view('livewire.match.register');
    }
}
