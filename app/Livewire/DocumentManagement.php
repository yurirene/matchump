<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Delegado;
use App\Models\Comissao;
use App\Models\Unidade;
use App\Models\Documento;
use App\Enums\TipoDocumentoEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Exception;
use Livewire\Attributes\Layout;

class DocumentManagement extends Component
{
    public $reunioes;

    public $documentoId;
    public $nome;
    public $numero;
    public $tipo;
    public $url;
    public $delegado_id;
    public $comissao_id;
    public $unidade_id;
    public $tenant_id_form;

    public $delegadosDisponiveis;
    public $comissoesDisponiveis;
    public $unidadesDisponiveis;
    public $tiposDocumento;
    public $exibirDelegado = false;
    public $exibirComissao = false;
    public $exibirUnidade = false;

    public $showForm = false;
    public $editing = false;

    protected function rules()
    {
        return [
            'nome' => 'required|string|max:255',
            'numero' => 'required|integer|min:1',
            'tipo' => 'required|in:' . implode(',', array_column(TipoDocumentoEnum::cases(), 'value')),
            'url' => 'required|url|max:2048',
            'delegado_id' => 'nullable|uuid|exists:delegados,id',
            'comissao_id' => 'nullable|uuid|exists:comissoes,id',
            'unidade_id' => 'nullable|uuid|exists:unidades,id',
        ];
    }

    public function mount()
    {
        $this->tenant_id_form = Auth::user()->tenant_id;

        $this->tiposDocumento = TipoDocumentoEnum::forSelect();

        $this->loadRelatedData();
    }
    

    public function loadRelatedData()
    {
        $this->delegadosDisponiveis = Delegado::where('status', true)
            ->with('unidade')
            ->get();

        $this->comissoesDisponiveis = Comissao::get();

        $this->unidadesDisponiveis = Unidade::all();
    }

    public function newDocumento()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function editDocumento(string $documentoId)
    {
        $documento = Documento::findOrFail($documentoId);
        if ($documento->tenant_id !== Auth::user()->tenant_id) {
            abort(403, 'Você não tem permissão para editar este documento.');
        }

        $this->documentoId = $documento->id;
        $this->nome = $documento->nome;
        $this->numero = $documento->numero;
        $this->tipo = $documento->tipo->value;
        $this->url = $documento->url;
        $this->delegado_id = $documento->delegado_id;
        $this->comissao_id = $documento->comissao_id;
        $this->unidade_id = $documento->unidade_id;
        $this->editing = true;
        $this->showForm = true;
    }

    public function saveDocumento()
    {
        $this->validate();

        try {
            // Converter strings vazias para null
            $delegado_id = $this->delegado_id === '' ? null : $this->delegado_id;
            $comissao_id = $this->comissao_id === '' ? null : $this->comissao_id;
            $unidade_id = $this->unidade_id === '' ? null : $this->unidade_id;
            
            $data = [
                'nome' => $this->nome,
                'numero' => $this->numero,
                'tipo' => $this->tipo,
                'url' => $this->url,
                'delegado_id' => $delegado_id,
                'comissao_id' => $comissao_id,
                'unidade_id' => $unidade_id,
            ];

            if ($this->editing) {
                Documento::find($this->documentoId)->update($data);
                session()->flash('documento-message', 'Documento atualizado com sucesso!');
            } else {
                $data['id'] = Str::uuid();
                Documento::create($data);
                session()->flash('documento-message', 'Documento criado com sucesso!');
            }

            $this->resetForm();
        } catch (Exception $e) {
            session()->flash('documento-error', 'Erro ao salvar documento: ' . $e->getMessage());
        }
    }

    public function deleteDocumento(string $documentoId)
    {
        try {
            $documento = Documento::findOrFail($documentoId);
            if ($documento->tenant_id !== Auth::user()->tenant_id) {
                abort(403, 'Você não tem permissão para excluir este documento.');
            }
            $documento->delete();
            session()->flash('documento-message', 'Documento excluído com sucesso!');
        } catch (Exception $e) {
            session()->flash('documento-error', 'Erro ao excluir documento: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->documentoId = null;
        $this->nome = '';
        $this->numero = null;
        $this->tipo = null;
        $this->url = '';
        $this->delegado_id = null;
        $this->comissao_id = null;
        $this->unidade_id = null;
        $this->editing = false;
        $this->showForm = false;
    }

    public function getDocumentosProperty()
    {
        return Documento::with(['delegado', 'comissao', 'unidade', 'reuniao'])
            ->orderBy('numero', 'asc')
            ->latest()
            ->get();
    }

    public function updatedTipo($value)
    {
        $this->exibirDelegado = in_array($value, [TipoDocumentoEnum::Substitutivo->value, TipoDocumentoEnum::Proposta->value, TipoDocumentoEnum::Outros->value]);
        $this->exibirComissao = in_array($value, [TipoDocumentoEnum::RelatorioComissao->value]);
        $this->exibirUnidade = in_array($value, [TipoDocumentoEnum::Consulta->value, TipoDocumentoEnum::Relatorio->value, TipoDocumentoEnum::Proposta->value]);
        
        // Limpar campos quando não são exibidos
        if (!$this->exibirDelegado) {
            $this->delegado_id = null;
        }
        if (!$this->exibirComissao) {
            $this->comissao_id = null;
        }
        if (!$this->exibirUnidade) {
            $this->unidade_id = null;
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.document-management', [
            'documentos' => $this->documentos,
        ]);
    }
}