<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Atas;
use App\Livewire\CommissionManagement;
use App\Livewire\DelegadoAtas;
use App\Livewire\DelegadoComissoes;
use App\Livewire\DelegadoDocumentos;
use App\Livewire\DelegadoHome;
use App\Livewire\DelegateManagement;
use App\Livewire\DocumentManagement;
use App\Livewire\PresenceManagement;
use App\Livewire\SessionManagement;
use App\Livewire\Match\Dashboard as MatchDashboard;
use App\Livewire\Match\Discovery as MatchDiscovery;
use App\Livewire\Match\Login as MatchLogin;
use App\Livewire\Match\MatchDetalhe as MatchDetalhe;
use App\Livewire\Match\Matches as MatchMatches;
use App\Livewire\Match\Perfil as MatchPerfil;
use App\Livewire\Match\Questionario as MatchQuestionario;
use App\Livewire\Match\Register as MatchRegister;
use App\Livewire\SyncUnidades;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::redirect('/matches', '/match/matches');

Route::middleware('guest:match')->group(function () {
    Route::get('/login', MatchLogin::class)->name('login');
    Route::get('/register', MatchRegister::class)->name('register');
});

Route::permanentRedirect('/match/login', '/login');
Route::permanentRedirect('/match/register', '/register');

Route::prefix('match')->name('match.')->group(function () {
    Route::middleware('auth:match')->group(function () {
        Route::post('/logout', function () {
            Auth::guard('match')->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect()->route('login');
        })->name('logout');

        Route::get('/dashboard', MatchDashboard::class)->name('dashboard');
        Route::get('/questionario', MatchQuestionario::class)->name('questionario');
        Route::get('/matches', MatchMatches::class)->name('matches');
        Route::get('/ver/{alvo}', MatchDetalhe::class)->name('detalhe');
        Route::get('/discovery', MatchDiscovery::class)->name('discovery');
        Route::get('/perfil', MatchPerfil::class)->name('perfil');
    });
});

require __DIR__.'/auth.php';
