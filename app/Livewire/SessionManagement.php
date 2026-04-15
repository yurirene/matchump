<?php

namespace App\Livewire;

use App\Services\SessaoService;
use Livewire\Component;
use App\Models\Sessao;
use Exception;
use Livewire\Attributes\Layout;

class SessionManagement extends Component
{
    public $sessaoId;
    public $sessaoNome;

    public $showForm = false;
    public $editing = false;

    protected $sessaoService;

    public function __construct()
    {
        $this->sessaoService = new SessaoService();
    }

    protected function rules()
    {
        return [
            'sessaoNome' => 'required|string|max:255',
        ];
    }

    public function mount()
    {
    }

    public function newSession()
    {
        $this->resetForm();
        $this->sessaoNome =  (Sessao::count() + 1) . 'ª Sessão';
        $this->editing = false;
        $this->showForm = true;
    }

    public function editSession(string $id)
    {
        $sessao = Sessao::findOrFail($id);

        $this->sessaoId = $sessao->id;
        $this->sessaoNome = $sessao->nome;
        $this->editing = true;
        $this->showForm = true;
    }

    public function saveSession()
    {
        $this->validate();

        try {
            if ($this->editing) {
                $this->sessaoService->updateSessao($this->sessaoId, $this->sessaoNome);
                session()->flash('message', 'Sessão atualizada com sucesso!');
            } else {
                $this->sessaoService->createSessao($this->sessaoNome);
                session()->flash('message', 'Sessão criada com sucesso!');
            }

            $this->resetForm();
        } catch (Exception $e) {
            session()->flash('error', 'Erro ao salvar sessão: ' . $e->getMessage());
        }
    }

    public function deleteSession(string $id)
    {
        try {
            Sessao::findOrFail($id)->delete();
            session()->flash('message', 'Sessão excluída com sucesso!');
        } catch (Exception $e) {
            session()->flash('error', 'Erro ao excluir sessão: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->sessaoId = null;
        $this->sessaoNome = '';
        $this->editing = false;
        $this->showForm = false;
    }

    public function getSessoesProperty()
    {
        return Sessao::with('reuniao')
            ->latest()
            ->get();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.session-management', [
            'sessoes' => $this->sessoes,
        ]);
    }
}