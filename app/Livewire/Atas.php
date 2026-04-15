<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Ata;
use App\Models\Sessao;
use Illuminate\Support\Facades\Auth;

class Atas extends Component
{
    public $nome;
    public $url;
    public $sessaoId;
    public $showForm = false;
    
    public $isEditing = false;
    public $editId;

    public $atas;
    public $sessoes;
    public $reuniaoAtivaId;

    protected function rules()
    {
        return [
            'nome' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'sessaoId' => 'required|uuid',
        ];
    }
    
    public function mount()
    {
        $this->reuniaoAtivaId = session('selectedReuniaoId');

        if ($this->reuniaoAtivaId) {
            $this->sessoes = Sessao::get();
            $this->loadAtas();
        } else {
            session()->flash('reuniao-error', 'Nenhuma reunião ativa selecionada.');
        }
    }

    public function loadAtas()
    {
        $this->atas = Ata::get();
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        $this->resetValidation();
        if ($this->showForm) {
            $this->reset(['nome', 'url', 'sessaoId']);
        }
    }

    public function saveAta()
    {
        $this->validate();

        if ($this->isEditing) {
            $ata = Ata::find($this->editId);
            $ata->nome = $this->nome;
            $ata->url = $this->url;
            $ata->sessao_id = $this->sessaoId;
            $ata->save();
        } else {
            Ata::create([
                'nome' => $this->nome,
                'url' => $this->url,
                'sessao_id' => $this->sessaoId,
            ]);
        }

        session()->flash('ata-message', 'Ata criada com sucesso!');
        $this->toggleForm();
        $this->loadAtas();
    }
    
    public function toggleAprovada(Ata $ata)
    {
        $ata->aprovada = !$ata->aprovada;
        $ata->save();
        $this->loadAtas();
        session()->flash('ata-message', 'Status da ata atualizado.');
    }

    public function edit(Ata $ata)
    {
        $this->isEditing = true;
        $this->editId = $ata->id;
        $this->nome = $ata->nome;
        $this->sessaoId = $ata->sessao_id;
        $this->url = $ata->url;
        $this->showForm = true;
    }

    
    public function cancelEdit()
    {
        $this->isEditing = false;
        $this->reset(['editId', 'nome', 'sessaoId', 'url']);
        $this->resetValidation();
    }
    
    public function resetForm()
    {
        $this->reset(['nome', 'url', 'sessaoId']);
        $this->resetValidation();
    }
    
    public function deleteAta(Ata $ata)
    {
        $ata->delete();
        session()->flash('ata-message', 'Ata excluída com sucesso!');
        $this->loadAtas();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.atas');
    }
}