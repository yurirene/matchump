<div class="container mt-4">
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body">
            <p class="mb-0 fw-bold">Atas da Reunião</p>
        </div>
    </div>

    @if (session()->has('reuniao-error'))
        <div class="alert alert-warning">{{ session('reuniao-error') }}</div>
    @elseif (session()->has('ata-voted'))
        <div class="alert alert-success">{{ session('ata-voted') }}</div>
    @elseif ($atas->isEmpty())
        <div class="alert alert-info">Nenhuma ata encontrada para esta reunião.</div>
    @else
        <div class="row">
            @foreach ($atas as $ata)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100 border-0 rounded-4">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <p class="fw-bold">{{ $ata->nome }}</p>
                            <div>
                                <span class="card-text text-muted">Status:</span>
                                @if ($ata->aprovacaoAtas->first()?->pivot->aprovado)
                                    <span class="badge bg-success">Você aprovou a ata</span>
                                @elseif ($ata->aprovacaoAtas->first()?->pivot->aprovado === 0)
                                    <span class="badge bg-danger">Você reprovou a ata</span>
                                @else
                                    <span class="badge bg-warning text-dark">Aguardando Votação</span>
                                @endif
                            </div>
                            <div class="mt-3">
                                <a href="{{ $ata->url }}" target="_blank" class="btn btn-outline-primary w-100 mb-2">
                                    <i class="bi bi-eye"></i> Visualizar Ata
                                </a>

                                @if (!$ata->aprovada && !$ata->reprovada)
                                    <div class="btn-group w-100" role="group">
                                        <button wire:click="aprovarAta('{{ $ata->id }}')" class="btn btn-success">
                                            <i class="bi bi-hand-thumbs-up"></i> Aprovar
                                        </button>
                                        <button wire:click="reprovarAta('{{ $ata->id }}')" class="btn btn-danger">
                                            <i class="bi bi-hand-thumbs-down"></i> Reprovar
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>