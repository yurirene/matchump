<div class="container mt-4">

    <div class="card shadow mb-4 rounded-4 border-0">
        <span class="p-3 d-flex text-dark text-decoration-none account-item align-items-center">
            <img src="/assets/img/avatar.svg" class="img-fluid rounded-circle me-3" style="width: 50px; height: 50px;" alt="profile-img">
            <div>
                <p class="fw-bold mb-0 pe-3 d-flex align-items-center">{{ $delegado->nome }}</p>
                <div class="text-muted fw-light">
                    <p class="mb-1 small">{{ $delegado->unidade->nome ?? 'N/A' }}</p>
                    @if ($delegado->cargo)
                        <span class="text-muted d-flex align-items-center small">
                            <i class="bi bi-person-badge me-2"></i> {{ $delegado->cargo->label() }}
                        </span>
                    @endif
                </div>
            </div>
        </span>
    </div>
    <div class="card shadow mb-4 rounded-4 border-0">
        <div class="card-body mb-0">
            <p class="mb-0">
                <b>Sessão Atual:</b> {{ $sessaoAtiva->nome ?? 'N/A' }}
                <span class="badge bg-{{ $sessaoAtiva->status ? 'success' : 'danger' }}">
                    {{ $sessaoAtiva->status ? 'Presente' : 'Ausente' }}
                </span>
            </p>
        </div>
    </div>
    @livewire('presenca-chart')

    @livewire('delegado-logout')
</div>