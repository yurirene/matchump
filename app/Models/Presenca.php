<?php

namespace App\Models;

use App\Traits\HasReuniaoAtiva;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presenca extends Model
{
    use HasFactory, UuidTrait, HasReuniaoAtiva;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'presencas';

    public function delegado()
    {
        return $this->belongsTo(Delegado::class);
    }

    public function sessao()
    {
        return $this->belongsTo(Sessao::class);
    }
}
