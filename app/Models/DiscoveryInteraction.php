<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscoveryInteraction extends Model
{
    use HasFactory;

    public const ACTION_INTERESTED = 'interested';

    public const ACTION_SKIP = 'skip';

    protected $fillable = [
        'viewer_id',
        'target_id',
        'action',
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
