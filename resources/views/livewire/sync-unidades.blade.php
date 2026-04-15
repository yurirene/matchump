<div class="">
    @section('title', 'Unidades')
    <div class="card shadow-sm">
        <div class="card-body">
            @if ($message)
                <div class="alert alert-success" role="alert">
                    {{ $message }}
                </div>
            @endif

            @if ($error)
                <div class="alert alert-danger" role="alert">
                    {{ $error }}
                </div>
            @endif

            <button wire:click="sync" class="btn btn-success mb-4" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="sync">
                    <i class="bi bi-arrow-repeat"></i> Sincronizar Agora
                </span>
                <span wire:loading wire:target="sync">
                    <i class="bi bi-arrow-repeat"></i> Sincronizando...
                </span>
            </button>

            <h5 class="mt-4">Unidades Sincronizadas:</h5>
            @if ($unidades->isEmpty())
                <p>Nenhuma unidade sincronizada ainda.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                @if(auth()->user()->sinodal)
                                    <th>Sigla</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($unidades as $unidade)
                                <tr>
                                    <td>{{ $unidade->nome }}</td>
                                    @if(auth()->user()->sinodal)
                                        <td>{{ $unidade->sigla }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>