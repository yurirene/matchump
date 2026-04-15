<?php

namespace App\Models;

use App\Traits\HasReuniaoAtiva;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Comissao extends Model
{
    use HasFactory, UuidTrait, HasReuniaoAtiva;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'comissoes';

    public function reuniao()
    {
        return $this->belongsTo(Reuniao::class);
    }

    public function delegados(): BelongsToMany
    {
        return $this->belongsToMany(Delegado::class, 'comissoes_delegados', 'comissao_id', 'delegado_id')
            ->withPivot('relator');
    }

    public function documentos(): BelongsToMany
    {
        return $this->belongsToMany(Documento::class, 'comissoes_documentos', 'comissao_id', 'documento_id')
            ->withPivot('aprovado');
    }

    public function relator()
    {
        return $this->delegados()->wherePivot('relator', true)->first();
    }
}