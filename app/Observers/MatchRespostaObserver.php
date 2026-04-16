<?php

namespace App\Observers;

use App\Models\MatchResposta;
use App\Services\MatchService;

class MatchRespostaObserver
{
    public function saved(MatchResposta $matchResposta): void
    {
        MatchService::invalidateScoresForUser($matchResposta->match_user_id);
    }

    public function deleted(MatchResposta $matchResposta): void
    {
        MatchService::invalidateScoresForUser($matchResposta->match_user_id);
    }
}
