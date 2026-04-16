<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatchResposta extends Model
{
    use HasFactory;

    protected $table = 'match_respostas';

    protected $fillable = [
        'match_user_id',
        'pergunta_id',
        'alternativa',
    ];

    public function matchUser(): BelongsTo
    {
        return $this->belongsTo(MatchUser::class, 'match_user_id');
    }

    public function pergunta(): BelongsTo
    {
        return $this->belongsTo(Pergunta::class, 'pergunta_id');
    }
}
