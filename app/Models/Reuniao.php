<?php

namespace App\Models;

use App\Traits\HasReuniaoAtiva;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reuniao extends Model
{
    use HasFactory, UuidTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'reunioes';

    public function sessoes()
    {
        return $this->hasMany(Sessao::class);
    }
}
