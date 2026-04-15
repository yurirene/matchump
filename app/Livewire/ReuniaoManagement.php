<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Reuniao;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use App\Services\ReuniaoService;

class ReuniaoManagement extends Component
{
    public $reuniaoId;
    public $ano;
    public $showForm = false;
    public $editing = false;
    private $reuniaoService;
    public $selectedReuniaoId;

    protected function rules()
    {
        return [
            'ano' => 'required|integer|min:1900|max:' . (date('Y') + 1),
        ];
    }

    public function __construct()
    {
        $this->reuniaoService = new ReuniaoService();
    }
    
    public function mount()
    {
        $this->selectedReuniaoId = session('selectedReuniaoId');
    }

    public function newReuniao()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function saveReuniao()
    {
        $this->validate();

        try {
            $data = [
                'ano' => $this->ano,
                'tenant_id' => auth()->user()->tenant_id,
            ];

            if ($this->editing) {
                $reuniao = Reuniao::find($this->reuniaoId);
                $reuniao->update($data);
                session()->flash('reuniao-message', 'Reunião atualizada com sucesso!');
            } else {
                $data['codigo'] = $this->reuniaoService->gerarCodigoReuniao($data['tenant_id']);
                Reuniao::create($data);
                session()->flash('reuniao-message', 'Reunião criada com sucesso!');
            }

            $this->resetForm();
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                session()->flash('reuniao-error', 'Já existe uma reunião para este ano.');
            } else {
                session()->flash('reuniao-error', 'Erro ao salvar reunião: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            session()->flash('reuniao-error', 'Erro ao salvar reunião: ' . $e->getMessage());
        }
    }

    public function editReuniao(string $reuniaoId)
    {
        $reuniao = Reuniao::findOrFail($reuniaoId);
        $this->reuniaoId = $reuniao->id;
        $this->ano = $reuniao->ano;
        $this->editing = true;
        $this->showForm = true;
    }

    public function encerrarReuniao(string $reuniaoId)
    {
        try {
            Reuniao::findOrFail($reuniaoId)->update(['status' => false]);
            session()->flash('reuniao-message', 'Reunião encerrada com sucesso!');
        } catch (\Exception $e) {
            session()->flash('reuniao-error', 'Erro ao encerrar reunião: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->reuniaoId = null;
        $this->ano = null;
        $this->editing = false;
        $this->showForm = false;
    }

    public function selectReuniao(string $reuniaoId)
    {
        $reuniao = Reuniao::where('id', $reuniaoId)
                          ->where('tenant_id', Auth::user()->tenant_id)
                          ->first();

        if ($reuniao) {
            session(['selectedReuniaoId' => $reuniaoId]);
            $this->selectedReuniaoId = $reuniaoId;
            session()->flash('reuniao-context', "Reunião '{$reuniao->codigo}' selecionada!");
        } else {
            session()->flash('reuniao-error', 'Reunião não encontrada ou você não tem permissão.');
        }
    }

    public function getReunioesProperty()
    {
        return Reuniao::where('tenant_id', auth()->user()->tenant_id)
            ->orderBy('ano', 'desc')
            ->get();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.reuniao-management', [
            'reunioes' => $this->reunioes,
        ]);
    }
}