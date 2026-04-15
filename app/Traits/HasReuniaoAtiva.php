<?php

namespace App\Traits;

use App\Models\Reuniao;
use App\Services\ReuniaoService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

trait HasReuniaoAtiva
{
    protected static array $reunioesAtivasCache = [];

    public static function bootHasReuniaoAtiva()
    {
        // 🔹 Evento para preencher reuniao_id automaticamente ao criar
        static::creating(function ($model) {
            $tenantId = $model->tenant_id ?? auth()->user()?->tenant_id;

            if (!$tenantId) {
                throw new \Exception("Tenant não definido para setar a reunião ativa.");
            }
            
            $model->tenant_id = $tenantId;
            $model->reuniao_id = self::getReuniaoAtiva($tenantId)->id;
        });

        static::addGlobalScope('tenant', function (Builder $builder) {
            $tenantId = auth()->user()?->tenant_id;

            if ($tenantId) {
                $builder->where($builder->getModel()->getTable() . '.tenant_id', $tenantId);
            }
        });

        static::addGlobalScope('reuniao_ativa', function (Builder $builder) {
            $tenantId = auth()->user()?->tenant_id;

            if ($tenantId) {
                $reuniaoAtiva = self::getReuniaoAtiva($tenantId);
                if ($reuniaoAtiva) {
                    $builder->where($builder->getModel()->getTable() . '.reuniao_id', $reuniaoAtiva->id);
                }
            }
        });
    }

    protected static function getReuniaoAtiva($tenantId)
    {
        // A lógica de cache é importante para não ir ao banco de dados repetidamente
        if (isset(self::$reunioesAtivasCache[$tenantId])) {
            return self::$reunioesAtivasCache[$tenantId];
        }

        // 1. Tenta carregar a reunião da sessão (a que foi selecionada no Livewire)
        $selectedReuniaoId = session('selectedReuniaoId');

        if ($selectedReuniaoId) {
            $reuniaoAtiva = Reuniao::where('tenant_id', $tenantId)
                                   ->find($selectedReuniaoId);
            if ($reuniaoAtiva) {
                self::$reunioesAtivasCache[$tenantId] = $reuniaoAtiva;
                return self::$reunioesAtivasCache[$tenantId];
            }
        }
        
        // 2. Fallback: Se nenhuma reunião foi selecionada ou se a ID da sessão não for válida,
        //    usa a lógica antiga baseada no status.
        $reuniaoAtiva = Reuniao::where('tenant_id', $tenantId)
            ->where('status', 1)
            ->first();

        // 3. Fallback final: Se não houver nenhuma reunião ativa, cria uma nova.
        if (!$reuniaoAtiva) {
            $reuniaoAtiva = Reuniao::create([
                'id' => Str::uuid(),
                'ano' => now()->year,
                'tenant_id' => $tenantId,
                'status' => true,
                'codigo' => app(ReuniaoService::class)->gerarCodigoReuniao($tenantId),
            ]);
            Log::info("Reunião ativa criada automaticamente para tenant {$tenantId}.");
        }

        self::$reunioesAtivasCache[$tenantId] = $reuniaoAtiva;
        return self::$reunioesAtivasCache[$tenantId];
    }
}
