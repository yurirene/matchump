<?php

namespace App\Livewire\Match;

use App\Services\MatchService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.match')]
#[Title('Perfil')]
class Perfil extends Component
{
    use WithFileUploads;

    public string $name = '';

    public string $birth_date = '';

    public string $sexo = '';

    public $avatar = null;

    public function mount(): void
    {
        $u = Auth::guard('match')->user();
        $this->name = $u->name;
        $this->birth_date = $u->birth_date->format('Y-m-d');
        $this->sexo = (string) ($u->sexo ?? '');
    }

    public function save(): void
    {
        $user = Auth::guard('match')->user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
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

        $user->name = $validated['name'];
        $user->birth_date = $validated['birth_date'];
        $user->sexo = $validated['sexo'];

        $upload = $validated['avatar'] ?? $this->avatar;
        if ($upload) {
            $stored = Storage::disk('public')->putFile('avatars', $upload);
            if ($stored !== false) {
                $user->avatar_path = $stored;
            }
        }

        $user->save();

        MatchService::invalidateScoresForUser($user->id);

        session()->flash('status', 'Perfil atualizado.');

        $this->avatar = null;
    }

    public function render()
    {
        return view('livewire.match.perfil', [
            'user' => Auth::guard('match')->user(),
        ]);
    }
}
