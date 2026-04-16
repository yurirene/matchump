<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatchScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'viewer_id',
        'target_id',
        'score_percent',
        'meta',
        'source_hash',
    ];

    protected $casts = [
        'score_percent' => 'decimal:2',
        'meta' => 'array',
    ];

    public function viewer(): BelongsTo
    {
        return $this->belongsTo(MatchUser::class, 'viewer_id');
    }

    public function target(): BelongsTo
    {
        return $this->belongsTo(MatchUser::class, 'target_id');
    }
}
