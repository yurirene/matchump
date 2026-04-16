<?php

namespace App\Livewire\Match;

use App\Models\DiscoveryInteraction;
use App\Services\MatchService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.match')]
#[Title('Descoberta')]
class Discovery extends Component
{
    public function interested(string $targetId): void
    {
        DiscoveryInteraction::query()->updateOrCreate(
            [
                'viewer_id' => Auth::guard('match')->id(),
                'target_id' => $targetId,
            ],
            ['action' => DiscoveryInteraction::ACTION_INTERESTED]
        );
    }

    public function skip(string $targetId): void
    {
        DiscoveryInteraction::query()->updateOrCreate(
            [
                'viewer_id' => Auth::guard('match')->id(),
                'target_id' => $targetId,
            ],
            ['action' => DiscoveryInteraction::ACTION_SKIP]
        );
    }

    public function render(MatchService $matchService)
    {
        $viewer = Auth::guard('match')->user();
        $row = $matchService->proximoDiscovery($viewer);

        return view('livewire.match.discovery', [
            'row' => $row,
        ]);
    }
}
