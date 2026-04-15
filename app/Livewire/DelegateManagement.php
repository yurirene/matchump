<?php

namespace App\Livewire;

use App\Services\DelegadoService;
use Livewire\Component;
use App\Models\Delegado;
use App\Models\Unidade;
use App\Enums\CargoDelegadoEnum;
use App\Enums\TipoDelegadoEnum;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;

class DelegateManagement extends Component
{
    public $delegadoId;
    public $nome;
    public $cpf;
    public $telefone;
    public $cargo;
    public $tipo = 1; // TipoDelegadoEnum::Delegado->value
    public $url_credencial;
    public $status = true;
    public $unidade_id;
    public $tenant_id;

    public $showForm = false;
    public $editing = false;

    public $selectedUnidadeId;
    public $unidades;

    public $cargos;
    public $tiposDelegado;

    protected $delegadoService;

    public function __construct()
    {
        $this->delegadoService = new DelegadoService();
    }

    protected function rules()
    {
        return [
            'nome' => 'required|string|max:255',
            'cpf' => [
                'required',
                'string',
                'size:11'
            ],
            'telefone' => 'nullable|string|max:20',
            'cargo' => 'nullable|in:' . implode(',', array_keys(CargoDelegadoEnum::forSelect())),
            'tipo' => 'required|in:' . implode(',', array_keys(TipoDelegadoEnum::forSelect())),
            'url_credencial' => 'nullable|url|max:2048',
            'status' => 'boolean',
            'unidade_id' => 'nullable|uuid|exists:unidades,id',
        ];
    }

    public function mount()
    {
        $this->cargos = CargoDelegadoEnum::forSelect();
        $this->tiposDelegado = TipoDelegadoEnum::forSelect();

        $user = Auth::user();
        $this->tenant_id = $user->instance_id;

        
        $this->unidades = Unidade::all();
        if ($this->unidades->isNotEmpty()) {
            $this->selectedUnidadeId = $this->unidades->first()->id;
            $this->unidade_id = $this->selectedUnidadeId;
        }
        
        // Inicializar com o valor padrão do enum
        $this->tipo = TipoDelegadoEnum::Delegado->value;
    }
    
    public function updatedSelectedUnidadeId($value)
    {
        $this->unidade_id = $value;
    }

    public function newDelegate()
    {
        $this->resetForm();
        $this->editing = false;
        $this->showForm = true;
    }

    public function editDelegate(string $id)
    {
        $delegado = Delegado::findOrFail($id);

        $this->delegadoId = $delegado->id;
        $this->nome = $delegado->nome;
        $this->cpf = $delegado->cpf;
        $this->telefone = $delegado->telefone;
        $this->cargo = $delegado->cargo?->value;
        $this->tipo = $delegado->tipo?->value;
        $this->url_credencial = $delegado->url_credencial;
        $this->status = $delegado->status ? true : false;
        $this->unidade_id = $delegado->unidade_id;
        $this->selectedUnidadeId = $delegado->unidade_id;
        $this->editing = true;
        $this->showForm = true;
    }

    public function saveDelegate()
    {
        $this->validate();

        try {
            $data = [
                'nome' => $this->nome,
                'cpf' => $this->cpf,
                'hash_cpf' => Hash::make($this->cpf),
                'telefone' => $this->telefone,
                'cargo' => $this->cargo instanceof CargoDelegadoEnum ? $this->cargo->value : $this->cargo,
                'tipo' => $this->tipo instanceof TipoDelegadoEnum ? $this->tipo->value : $this->tipo,
                'url_credencial' => $this->url_credencial,
                'status' => $this->status,
                'unidade_id' => $this->unidade_id
            ];

            if ($this->editing) {
                $this->delegadoService->updateDelegado($this->delegadoId, $data);
                session()->flash('message', 'Delegado atualizado com sucesso!');
            } else {
                $this->delegadoService->createDelegado($data);
                session()->flash('message', 'Delegado cadastrado com sucesso!');
            }

            $this->resetForm();
            $this->showForm = false;
        } catch (Exception $e) {
            session()->flash('error', 'Erro ao salvar delegado: ' . $e->getMessage());
            Log::error('Delegate save error: ' . $e->getMessage());
        }
    }

    public function deleteDelegate(string $id)
    {
        try {
            $this->delegadoService->deleteDelegado($id);
            session()->flash('message', 'Delegado removido com sucesso!');
        } catch (Exception $e) {
            session()->flash('error', 'Erro ao excluir delegado: ' . $e->getMessage());
            Log::error('Delegate delete error: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->delegadoId = null;
        $this->nome = '';
        $this->cpf = '';
        $this->telefone = '';
        $this->cargo = null;
        $this->tipo = TipoDelegadoEnum::Delegado->value;
        $this->url_credencial = '';
        $this->status = true;
        $this->unidade_id = $this->selectedUnidadeId;
        $this->editing = false;
        $this->showForm = false;
    }

    public function getDelegadosProperty()
    {
        $user = Auth::user();
        $query = Delegado::query();
        if ($this->unidade_id) {
            $query->where('unidade_id', $this->unidade_id);
        }

        return $query->with('unidade')->latest()->get();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.delegate-management', [
            'delegados' => $this->delegados,
        ]);
    }
}