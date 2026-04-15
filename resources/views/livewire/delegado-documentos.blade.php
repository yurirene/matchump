<div class="container mt-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <p class="fw-bold">Documentos</p>
        </div>
        <div class="card-body">
            @if (session()->has('reuniao-error'))
                <div class="alert alert-warning">{{ session('reuniao-error') }}</div>
            @elseif ($documentos->isEmpty())
                <div class="alert alert-info">Nenhum documento encontrado para esta reunião.</div>
            @else
                <div class="table-responsive">
                    <div class="list-group">
                        @foreach ($documentos as $documento)
                            <div class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <div class="flex-grow-1">
                                    <div class="">
                                        <a href="{{ $documento->url }}" target="_blank" class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <span class="badge bg-primary">Doc Nº {{ $documento->numero }}</span>
                                        <span style="font-size: 12px;">{{ $documento->nome }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>