<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pergunta extends Model
{
    use HasFactory;

    protected $fillable = [
        'ordem',
        'texto',
        'opcoes',
    ];

    protected $casts = [
        'opcoes' => 'array',
    ];

    public function respostas(): HasMany
    {
        return $this->hasMany(MatchResposta::class, 'pergunta_id');
    }
}
