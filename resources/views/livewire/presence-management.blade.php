<div class="container mt-4">
    @section('title', "Presenças - Sessão: {$sessao->nome}")
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Resumo da Sessão</h5>
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-1">
                        <b>Total de Delegados:</b> {{ $this->totalDelegadosAtivos }}
                    </p>
                    <p class="mb-1">
                        <b>Delegados Presentes:</b> <span class="badge bg-success">{{ $this->delegadosPresentesCount }}</span>
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1">
                        <b>Unidades com Delegados Presentes:</b> <span class="badge bg-primary">{{ $this->quorum['presentes'] }}</span> de {{ $totalUnidades }}
                    </p>
                    <p class="mb-1">
                        <b>Quórum necessário:</b> {{ $this->quorum['necessario'] }}
                        @if ($this->quorum['atingido'])
                            <span class="badge bg-success ms-2">Atingido!</span>
                        @else
                            <span class="badge bg-warning ms-2">Ainda não</span>
                        @endif
                        
                        <br>
                        <small class="text-muted">
                            (mais da metade das Federações/UMPs Locais)
                        </small>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif

            <a href="{{ route('sessoes.index') }}" class="btn btn-secondary mb-4">
                <i class="bi bi-arrow-left"></i> Voltar para Sessões
            </a>
            <a href="#" class="btn btn-primary mb-4" wire:click="reloadDelegados">
                <i class="bi bi-sync"></i> Recarregar Delegados
            </a>

            
            @if ($presencas['titulares']->isEmpty() && $presencas['suplentes']->isEmpty())
                <p>Nenhum delegado cadastrado para esta sessão.</p>
            @else
                <h5 class="mt-4">Lista Diretoria</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Delegado</th>
                                <th>Unidade</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($presencas['diretoria'] as $presenca)
                                <tr>
                                    <td>{{ $presenca->delegado->nome }}</td>
                                    <td>{{ $presenca->delegado->unidade->nome ?? 'N/A' }}</td>
                                    <td>
                                        @if ($presenca->presente)
                                            <span class="badge bg-success">Presente</span>
                                        @else
                                            <span class="badge bg-danger">Ausente</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button wire:click="togglePresence('{{ $presenca->id }}')" class="btn btn-sm {{ $presenca->presente ? 'btn-danger' : 'btn-success' }}">
                                            {{ $presenca->presente ? 'Marcar Ausente' : 'Marcar Presente' }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <h5 class="mt-4">Lista Secretarios</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Delegado</th>
                                <th>Unidade</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($presencas['secretarios'] as $presenca)
                                <tr>
                                    <td>{{ $presenca->delegado->nome }}</td>
                                    <td>{{ $presenca->delegado->unidade->nome ?? 'N/A' }}</td>
                                    <td>
                                        @if ($presenca->presente)
                                            <span class="badge bg-success">Presente</span>
                                        @else
                                            <span class="badge bg-danger">Ausente</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button wire:click="togglePresence('{{ $presenca->id }}')" class="btn btn-sm {{ $presenca->presente ? 'btn-danger' : 'btn-success' }}">
                                            {{ $presenca->presente ? 'Marcar Ausente' : 'Marcar Presente' }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <h5 class="mt-4">Lista de Delegados</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Delegado</th>
                                <th>Unidade</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($presencas['titulares'] as $presenca)
                                <tr>
                                    <td>{{ $presenca->delegado->nome }}</td>
                                    <td>{{ $presenca->delegado->unidade->nome ?? 'N/A' }}</td>
                                    <td>
                                        @if ($presenca->presente)
                                            <span class="badge bg-success">Presente</span>
                                        @else
                                            <span class="badge bg-danger">Ausente</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button wire:click="togglePresence('{{ $presenca->id }}')" class="btn btn-sm {{ $presenca->presente ? 'btn-danger' : 'btn-success' }}">
                                            {{ $presenca->presente ? 'Marcar Ausente' : 'Marcar Presente' }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <h5 class="mt-4">Lista de Suplentes</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Suplente</th>
                                <th>Unidade</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($presencas['suplentes'] as $presenca)
                                <tr>
                                    <td>{{ $presenca->delegado->nome }}</td>
                                    <td>{{ $presenca->delegado->unidade->nome ?? 'N/A' }}</td>
                                    <td>
                                        @if ($presenca->presente)
                                            <span class="badge bg-success">Presente</span>
                                        @else
                                            <span class="badge bg-danger">Ausente</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button wire:click="togglePresence('{{ $presenca->id }}')" class="btn btn-sm {{ $presenca->presente ? 'btn-danger' : 'btn-success' }}">
                                            {{ $presenca->presente ? 'Marcar Ausente' : 'Marcar Presente' }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>