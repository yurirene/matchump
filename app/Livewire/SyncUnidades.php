<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\ExternalApiService;
use App\Models\Federation;
use App\Models\Unidade;
use Exception;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;

class SyncUnidades extends Component
{
    public $message = '';
    public $error = '';
    public $unidadesCount = 0; // Para mostrar quantas foram sincronizadas

    protected ExternalApiService $externalApiService;

    public function __construct()
    {
        $this->externalApiService = new ExternalApiService();
    }

    public function sync()
    {
        $this->message = '';
        $this->error = '';
        $this->unidadesCount = 0;

        try {
            // Busca as federações do sistema externo
            $unidades = $this->externalApiService->getUnidades();

            if (is_null($unidades)) {
                $this->error = 'Não foi possível buscar as federações do sistema externo. Verifique os logs.';
                Log::warning('SyncFederations: externalApiService->getFederations() returned null.');
                return;
            }

            $count = 0;
            foreach ($unidades as $unidade) {
                // Sincroniza (cria ou atualiza) a federação no seu banco de dados
                Unidade::updateOrCreate(
                    ['id_externo' => $unidade['id']], // Campo para identificar no seu DB
                    [
                        'nome' => $unidade['nome'],
                        'sigla' => $unidade['sigla'] ?? null,
                    ]
                );
                $count++;
            }

            $this->unidadesCount = $count;
            $this->message = "{$count} unidades sincronizadas com sucesso!";
            Log::info("SyncUnidades: {$count} unidades sincronizadas.");

        } catch (Exception $e) {
            $this->error = 'Ocorreu um erro durante a sincronização: ' . $e->getMessage();
            Log::error("SyncUnidades Error: " . $e->getMessage());
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        // Você pode listar as federações existentes aqui para visualização
        $unidades = Unidade::all();
        return view('livewire.sync-unidades', compact('unidades'));
    }
}