<?php

namespace App\Models;

use App\Traits\HasReuniaoAtiva;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    use HasFactory, UuidTrait, HasReuniaoAtiva;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'unidades';

    public function delegados()
    {
        return $this->hasMany(Delegado::class);
    }
}
