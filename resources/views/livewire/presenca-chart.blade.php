<div class="card shadow-sm border-0 rounded-4 p-3">
    <div class="row">
        <div class="col-md-6">
            <p class="fw-bold">Presença</p>
            <p class="mb-0">Total de Delegados: {{ $totalDelegados }}</p>
            <p class="mb-0">
                Quantidade de Presentes: {{ $presentesCount }}
            </p>
            <p class="mb-0">
                Quorum: {{ $metadeQuorum }}
            </p>
            <p class="mb-0">
                Status do Quorum: 
                @if ($temQuorum)
                    <span class="badge bg-success">Atingido</span>
                @else
                    <span class="badge bg-danger">Não Atingido</span>
                @endif
            </p>
        </div>
    </div>
</div>
