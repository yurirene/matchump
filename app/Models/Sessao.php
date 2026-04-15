<?php

namespace App\Models;

use App\Traits\HasReuniaoAtiva;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sessao extends Model
{
    use HasFactory, UuidTrait, HasReuniaoAtiva;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'sessoes';

    public function reuniao()
    {
        return $this->belongsTo(Reuniao::class);
    }
}
