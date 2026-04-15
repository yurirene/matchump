<div class="container mt-4">
    @section('title', 'Sessões')
    <div class="card shadow-sm">
        <div class="card-body">
            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <button wire:click="newSession" class="btn btn-success mb-4">
                <i class="bi bi-plus-circle"></i> Nova Sessão
            </button>

            @if ($showForm)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>{{ $editing ? 'Editar Sessão' : 'Criar Nova Sessão' }}</h5>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="saveSession">
                            <div class="mb-3">
                                <label for="sessaoNome" class="form-label">Nome da Sessão</label>
                                <input wire:model.defer="sessaoNome" type="text" class="form-control @error('sessaoNome') is-invalid @enderror" id="sessaoNome">
                                @error('sessaoNome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="saveSession">
                                    <i class="bi bi-floppy"></i> Salvar
                                </span>
                                <span wire:loading wire:target="saveSession">
                                    <i class="bi bi-arrow-repeat"></i> Salvando...
                                </span>
                            </button>
                            <button type="button" wire:click="resetForm" class="btn btn-secondary ms-2">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <h5 class="mt-4">Sessões Cadastradas</h5>
            @if ($sessoes->isEmpty())
                <p>Nenhuma sessão cadastrada para sua sinodal.</p>
            @else
                <div class="table-responsive" style="min-height: 500px;">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nome da Sessão</th>
                                <th>Reunião (Ano)</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sessoes as $sessao)
                                <tr>
                                    <td>{{ $sessao->nome }}</td>
                                    <td>{{ $sessao->reuniao->ano ?? 'N/A' }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $sessao->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $sessao->id }}">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('sessoes.presenca', ['sessaoId' => $sessao->id]) }}">
                                                        <i class="bi bi-people-fill me-2"></i>Presenças
                                                    </a>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item" wire:click="editSession('{{ $sessao->id }}')">
                                                        <i class="bi bi-pencil-square me-2"></i>Editar
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item text-danger" wire:click="deleteSession('{{ $sessao->id }}')" onclick="confirm('Tem certeza?') || event.stopImmediatePropagation()">
                                                        <i class="bi bi-trash-fill me-2"></i>Excluir
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
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