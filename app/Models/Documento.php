<?php

namespace App\Models;

use App\Enums\TipoDocumentoEnum;
use App\Traits\HasReuniaoAtiva;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Documento extends Model
{
    use HasFactory, UuidTrait, HasReuniaoAtiva;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'documentos';
    protected $casts = [
        'tipo' => TipoDocumentoEnum::class,
    ];

    public function reuniao()
    {
        return $this->belongsTo(Reuniao::class);
    }

    public function delegado()
    {
        return $this->belongsTo(Delegado::class);
    }

    public function comissao()
    {
        return $this->belongsTo(Comissao::class);
    }

    public function comissoes(): BelongsToMany
    {
        return $this->belongsToMany(Comissao::class, 'comissoes_documentos', 'documento_id', 'comissao_id')
            ->withPivot('aprovado');
    }

    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }
}
