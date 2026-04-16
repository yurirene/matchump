<?php

namespace App\Providers;

use App\Models\MatchResposta;
use App\Observers\MatchRespostaObserver;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Fortify::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        MatchResposta::observe(MatchRespostaObserver::class);
    }
}
