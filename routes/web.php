<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Atas;
use App\Livewire\CommissionManagement;
use App\Livewire\DelegadoAtas;
use App\Livewire\DelegadoComissoes;
use App\Livewire\DelegadoDocumentos;
use App\Livewire\DelegadoHome;
use App\Livewire\DelegateLogin;
use App\Livewire\DelegateManagement;
use App\Livewire\DocumentManagement;
use App\Livewire\PresenceManagement;
use App\Livewire\SessionManagement;
use App\Livewire\SyncUnidades;
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
    return view('welcome');
})->name('home');

Route::get('/delegados-login', DelegateLogin::class)->name('login.delegados');
Route::middleware(['auth:delegados'])
    ->prefix('area-delegado')
    ->name('area-delegado.')
    ->group(function () {
        Route::get('/', DelegadoHome::class)->name('home');
        Route::get('/documentos', DelegadoDocumentos::class)->name('documentos');
        Route::get('/comissoes', DelegadoComissoes::class)->name('comissoes');
        Route::get('/atas', DelegadoAtas::class)->name('atas');
    }
);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/unidades', SyncUnidades::class)->name('unidades.index');
    Route::get('/delegados', DelegateManagement::class)->name('delegados.index');
    Route::get('/sessoes', SessionManagement::class)->name('sessoes.index');
    Route::get('/sessoes/{sessaoId}/presencas', PresenceManagement::class)->name('sessoes.presenca');
    Route::get('/comissoes', CommissionManagement::class)->name('comissoes.index');
    Route::get('/documentos', DocumentManagement::class)->name('documentos.index');
    Route::get('/atas', Atas::class)->name('atas.index');
});

require __DIR__.'/auth.php';
