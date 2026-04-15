<?php

namespace App\Models;

use App\Traits\HasReuniaoAtiva;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ata extends Model
{
    use HasFactory, HasReuniaoAtiva, UuidTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'atas';
    protected $casts = [
        'aprovada' => 'boolean',
    ];

    public function sessao()
    {
        return $this->belongsTo(Sessao::class);
    }

    public function aprovacaoAtas()
    {
        return $this->belongsToMany(Delegado::class, 'aprovacao_atas', 'ata_id', 'delegado_id')
            ->withPivot('aprovado');
    }

}
