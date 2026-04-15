<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Reuniao;
use App\Models\Comissao;
use App\Models\Delegado;
use App\Models\Documento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;

class CommissionManagement extends Component
{
    public $reunioes; // Lista de reuniões disponíveis
    public $selectedReuniaoId; // O ID da reunião selecionada

    public $comissaoId;
    public $comissaoNome;
    public $showComissaoForm = false;
    public $editingComissao = false;

    public $comissaoToManageMembers;
    public $availableDelegates;
    public $members;
    public $delegateToAdd;
    public $currentRelatorId;
    public $apenasNaoAdicionados = false;
    public $showMembersForm = false;

    public $comissaoToManageDocuments;
    public $availableDocuments;
    public $documents;
    public $documentToAdd;
    public $showDocumentsForm = false;
    public $producedDocuments;

    protected function rules()
    {
        return [
            'comissaoNome' => 'required|string|max:255',
        ];
    }

    public function mount()
    {
        $this->reunioes = Reuniao::where('tenant_id', auth()->user()->tenant_id)
            ->where('status', true)
            ->firstOrFail();
            
        $this->selectedReuniaoId = $this->reunioes->id;
    }
    
    // Método para resetar o formulário de comissão
    public function newComissao()
    {
        $this->resetComissaoForm();
        $this->showComissaoForm = true;
    }

    public function editComissao(string $comissaoId)
    {
        $comissao = Comissao::findOrFail($comissaoId);
        $this->comissaoId = $comissao->id;
        $this->comissaoNome = $comissao->nome;
        $this->editingComissao = true;
        $this->showComissaoForm = true;
    }

    public function saveComissao()
    {
        $this->validate();

        try {
            $data = [
                'nome' => $this->comissaoNome
            ];

            if ($this->editingComissao) {
                Comissao::find($this->comissaoId)->update($data);
                session()->flash('comissao-message', 'Comissão atualizada com sucesso!');
            } else {
                Comissao::create($data);
                session()->flash('comissao-message', 'Comissão criada com sucesso!');
            }
            $this->resetComissaoForm();
        } catch (Exception $e) {
            session()->flash('comissao-error', 'Erro ao salvar comissão: ' . $e->getMessage());
        }
    }

    public function deleteComissao(string $comissaoId)
    {
        try {
            Comissao::findOrFail($comissaoId)->delete();
            session()->flash('comissao-message', 'Comissão excluída com sucesso!');
        } catch (Exception $e) {
            session()->flash('comissao-error', 'Erro ao excluir comissão: ' . $e->getMessage());
        }
    }

    public function resetComissaoForm()
    {
        $this->comissaoId = null;
        $this->comissaoNome = '';
        $this->editingComissao = false;
        $this->showComissaoForm = false;
        $this->comissaoToManageMembers = null;
    }

    public function manageMembers(string $comissaoId)
    {
        $this->comissaoToManageMembers = Comissao::with(['delegados' => function ($query) {
            $query->withPivot('relator');
        }])->findOrFail($comissaoId);
        $this->loadMembers();
        $this->showMembersForm = true;
        $this->showDocumentsForm = false;
    }

    public function loadMembers()
    {
        $this->members = $this->comissaoToManageMembers->delegados;
        $this->currentRelatorId = $this->members->where('pivot.relator', true)->first()->id ?? null;
        
        $query = Delegado::where('tenant_id', Auth::user()->tenant_id)
            ->where('status', true);

        $query->whereDoesntHave('comissoes', function ($q) {
            $q->where('comissoes.id', $this->comissaoToManageMembers->id);
        });

        if ($this->apenasNaoAdicionados) {
            $query->whereDoesntHave('comissoes');
        }
        
        $this->availableDelegates = $query->get();
    }

    public function addMember()
    {
        if (!$this->delegateToAdd) {
            session()->flash('member-error', 'Selecione um membro para adicionar!');
            return;
        }
        $tenantId = auth()->user()->tenant_id;
        $reuniaoId = $this->selectedReuniaoId;
        $this->comissaoToManageMembers->delegados()->attach($this->delegateToAdd, ['tenant_id' => $tenantId, 'reuniao_id' => $reuniaoId, 'relator' => false]);
        $this->loadMembers();
        $this->delegateToAdd = null;
        session()->flash('member-message', 'Membro adicionado com sucesso!');
    }

    public function removeMember(string $delegadoId)
    {
        $this->comissaoToManageMembers->delegados()->detach($delegadoId);
        $this->loadMembers();
        session()->flash('member-message', 'Membro removido com sucesso!');
    }

    public function setRelator(string $delegadoId)
    {
        try {
            DB::beginTransaction();

            if ($this->currentRelatorId) {
                $this->comissaoToManageMembers->delegados()->updateExistingPivot(
                    $this->currentRelatorId,
                    ['relator' => false]
                );
            }

            $this->comissaoToManageMembers->delegados()->updateExistingPivot(
                $delegadoId,
                ['relator' => true]
            );

            DB::commit();

            session()->flash('member-message', 'Relator definido com sucesso!');
            $this->loadMembers();
        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('member-error', 'Erro ao definir relator: ' . $e->getMessage());
        }
    }

    public function getComissoesProperty()
    {
        return Comissao::with(['delegados' => function($query) {
                $query->withPivot('relator');
            }])
            ->get();
    }

    public function updatedApenasNaoAdicionados()
    {
        $this->loadMembers();
    }

    public function manageDocuments(string $comissaoId)
    {
        $this->comissaoToManageDocuments = Comissao::findOrFail($comissaoId);
        $this->loadDocuments();
        $this->showDocumentsForm = true;
        $this->showMembersForm = false;
    }

    public function loadDocuments()
    {
        $this->documents = $this->comissaoToManageDocuments->documentos()->withPivot('aprovado')->get();
        $this->availableDocuments = Documento::whereDoesntHave('comissoes')->get();
        $this->producedDocuments = Documento::whereHas('comissao', function ($q) {
            $q->where('comissoes.id', $this->comissaoToManageDocuments->id);
        })->get();
    }

    public function resetDocumentsForm()
    {
        $this->comissaoToManageDocuments = null;
        $this->documents = [];
        $this->showDocumentsForm = false;
    }

    public function addDocument()
    {
        $this->comissaoToManageDocuments->documentos()->attach(
            $this->documentToAdd, 
            ['tenant_id' => auth()->user()->tenant_id, 'reuniao_id' => $this->selectedReuniaoId]
        );
        $this->loadDocuments();
        $this->documentToAdd = null;
        session()->flash('document-message', 'Documento adicionado com sucesso!');
    }

    public function removeDocument(string $documentoId)
    {
        $this->comissaoToManageDocuments->documentos()->detach($documentoId);
        $this->loadDocuments();
        session()->flash('document-message', 'Documento removido com sucesso!');
    }

    public function aprovarDocumento(string $documentoId)
    {
        $this->comissaoToManageDocuments->documentos()->updateExistingPivot($documentoId, ['aprovado' => true]);
        $this->loadDocuments();
        session()->flash('document-message', 'Documento aprovado com sucesso!');
    }

    public function reprovarDocumento(string $documentoId)
    {
        $this->comissaoToManageDocuments->documentos()->updateExistingPivot($documentoId, ['aprovado' => false]);
        $this->loadDocuments();
        session()->flash('document-message', 'Documento reprovado com sucesso!');
    }


    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.commission-management', [
            'comissoes' => $this->comissoes,
        ]);
    }
}