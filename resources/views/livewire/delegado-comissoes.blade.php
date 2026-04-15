<div class="container mt-4">
    <div class="card shadow border-0 rounded-4 p-2">
        <div class="card-body">
        @if (session()->has('error'))
        <div class="alert alert-warning">{{ session('error') }}</div>
        @elseif ($comissoes->isEmpty())
        <div class="alert alert-info">Você não pertence a nenhuma comissão nesta reunião.</div>
        @else
        <p class="fw-bold mb-0">@if(count($comissoes) > 1) Minhas Comissões @else Minha Comissão @endif</p>
        @endif
        </div>
    </div>
    @foreach ($comissoes as $comissao)

    <div class="card shadow mt-4 rounded-4 border-0">
        <div class="card-body p-3">
            <p class="fw-bold mb-0">{{ $comissao->nome }}</p>
            <p> Relator: </p>
            <span class="p-3 d-flex text-dark text-decoration-none account-item align-items-center">
                <img src="/assets/img/avatar.svg" class="img-fluid rounded-circle me-3" style="width: 30px" alt="profile-img">
                <div>
                    <p class="fw-bold mb-0 pe-3 d-flex align-items-center">{{ $relator[$comissao->id]->nome }}</p>
                    <div class="text-muted fw-light">
                        <p class="mb-1 small">{{ $relator[$comissao->id]->unidade->nome ?? 'N/A' }}</p>
                        @if ($relator[$comissao->id]->cargo)
                        <span class="text-muted d-flex align-items-center small">
                            <i class="bi bi-person-badge me-2"></i> {{ $relator[$comissao->id]->cargo->label() }}
                        </span>
                        @endif
                    </div>
                </div>
            </span>
            <hr>
            <div class="mb-3">
                <p class="fw-bold mb-1">Documentos da Comissão:</p>
                <div class="list-group mb-2">
                    @forelse ($documentosDaComissao[$comissao->id] as $documento)
                        <div class="list-group-item">
                            <a href="{{ $documento->url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </a>
                            <span class="badge bg-primary">Doc Nº {{ $documento->numero }}</span>
                            <span style="font-size: 12px;">{{ $documento->nome }}</span>
                        </div>
                    @empty
                        <p class="text-muted small mb-0">Nenhum documento associado.</p>
                    @endforelse
                </div>
            </div>

            <div>
                <p class="fw-bold mb-1">Documentos Produzidos:</p>
                <div class="list-group mb-2">
                @forelse ($documentosProduzidos[$comissao->id] as $documento)
                        <div class="list-group-item">
                            <a href="{{ $documento->url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </a>
                            <span class="badge bg-primary">Doc Nº {{ $documento->numero }}</span>
                            <span style="font-size: 12px;">{{ $documento->nome }}</span>
                        </div>
                    @empty
                        <p class="text-muted small mb-0">Nenhum documento associado.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>