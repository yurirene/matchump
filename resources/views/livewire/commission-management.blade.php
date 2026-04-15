<div class="container-fluid mt-4">
    @section('title', 'Comissões')
    <div class="row">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    @if (session()->has('comissao-message'))
                        <div class="alert alert-success">{{ session('comissao-message') }}</div>
                    @endif
                    @if (session()->has('comissao-error'))
                        <div class="alert alert-danger">{{ session('comissao-error') }}</div>
                    @endif

                    <button wire:click="newComissao" class="btn btn-success mb-4">
                        <i class="bi bi-plus-circle"></i> Nova Comissão
                    </button>

                    @if ($showComissaoForm)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>{{ $editingComissao ? 'Editar Comissão' : 'Criar Nova Comissão' }}</h5>
                            </div>
                            <div class="card-body">
                                <form wire:submit.prevent="saveComissao">
                                    <div class="mb-3">
                                        <label for="comissaoNome" class="form-label">Nome da Comissão</label>
                                        <input wire:model.defer="comissaoNome" type="text" class="form-control @error('comissaoNome') is-invalid @enderror" id="comissaoNome">
                                        @error('comissaoNome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-floppy"></i> Salvar
                                    </button>
                                    <button type="button" wire:click="resetComissaoForm" class="btn btn-secondary ms-2">
                                        <i class="bi bi-x-circle"></i> Cancelar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    <h5 class="mt-4">Lista de Comissões</h5>
                    @if ($comissoes->isEmpty())
                        <p>Nenhuma comissão encontrada.</p>
                    @else
                        <div class="table-responsive" style="min-height: 400px;">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nome da Comissão</th>
                                        <th>Qtd Membros</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($comissoes as $comissao)
                                        <tr>
                                            <td>{{ $comissao->nome }}</td>
                                            <td>{{ $comissao->delegados->count() }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $comissao->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Ações
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $comissao->id }}">
                                                        <li>
                                                            <a class="dropdown-item" href="#" wire:click.prevent="manageMembers('{{ $comissao->id }}')">
                                                                <i class="bi bi-people"></i> Membros
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#" wire:click.prevent="manageDocuments('{{ $comissao->id }}')">
                                                                <i class="bi bi-file-earmark-text"></i> Documentos
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#" wire:click.prevent="editComissao('{{ $comissao->id }}')">
                                                                <i class="bi bi-pencil"></i> Editar
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item text-danger" href="#" wire:click.prevent="deleteComissao('{{ $comissao->id }}')" onclick="confirm('Tem certeza?') || event.stopImmediatePropagation()">
                                                                <i class="bi bi-trash"></i> Excluir
                                                            </a>
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
        <div class="col-md-7">
            @if ($showMembersForm)
                <div class="card shadow-sm">
                   
                    <div class="card-body">
                        @if (session()->has('member-message'))
                            <div class="alert alert-success">{{ session('member-message') }}</div>
                        @endif

                        <div class="row">
                            <div class="col-md-12">
                                <h6>
                                    Adicionar Membro
                                </h6>
                                <input class="form-check-input" type="checkbox" wire:model.live="apenasNaoAdicionados" id="apenasNaoAdicionados">
                                <label class="form-check-label" for="apenasNaoAdicionados">
                                    Listar apenas não adicionados em outras comissões
                                </label>
                                <div class="input-group">
                                    <select wire:model.live="delegateToAdd" class="form-select">
                                        <option value="">Selecione um delegado</option>
                                        @foreach ($availableDelegates as $delegado)
                                            <option value="{{ $delegado->id }}">{{ $delegado->nome }} ({{ $delegado->unidade?->sigla ?? 'N/A' }})</option>
                                        @endforeach
                                    </select>
                                    <button wire:click="addMember" class="btn btn-primary" {{ !$delegateToAdd ? 'disabled' : '' }}>Adicionar</button>
                                </div>
                            </div>
                            <div class="col-md-12 mt-4">
                                <h6>Membros Atuais</h6>
                                <ul class="list-group">
                                @forelse ($members as $delegado)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>
                                            {{ $delegado->nome }} ({{ $delegado->unidade->nome ?? 'N/A' }})
                                            @if ($delegado->pivot && $delegado->pivot->relator)
                                                <span class="badge bg-primary ms-2">
                                                    Relator
                                                </span>
                                            @endif
                                        </span>
                                        <div>
                                            @if ($delegado->pivot &&!$delegado->pivot->relator)
                                                <button wire:click="setRelator('{{ $delegado->id }}')" class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Definir como relator">
                                                    <i class="bi bi-person-check"></i>
                                                </button>
                                            @endif
                                            <button wire:click="removeMember('{{ $delegado->id }}')" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Remover membro">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </li>
                                @empty
                                    <li class="list-group-item">Nenhum membro nesta comissão.</li>
                                @endforelse
                                </ul>
                            </div>
                        </div>
                        <button wire:click="$set('comissaoToManageMembers', null)" class="btn btn-secondary mt-3">Fechar</button>
                    </div>
                </div>
            @endif

            @if ($showDocumentsForm)
                <div class="card shadow-sm">
                   
                    <div class="card-body">
                        @if (session()->has('member-message'))
                            <div class="alert alert-success">{{ session('member-message') }}</div>
                        @endif

                        <div class="row">
                            <div class="col-md-12">
                                <h6>
                                    Adicionar Documento
                                </h6>
                                <div class="input-group">
                                    <select wire:model.live="documentToAdd" class="form-select">
                                        <option value="">Selecione um documento</option>
                                        @foreach ($availableDocuments as $documento)
                                            <option value="{{ $documento->id }}">{{ $documento->nome }} ({{ $documento->numero }})</option>
                                        @endforeach
                                    </select>
                                    <button wire:click="addDocument" class="btn btn-primary" {{ !$documentToAdd ? 'disabled' : '' }}>Adicionar</button>
                                </div>
                            </div>
                            <div class="col-md-12 mt-4">
                                <h6>Documentos Atuais</h6>
                                <ul class="list-group">
                                @forelse ($documents as $documento)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge bg-primary">
                                                Doc. Nº {{ $documento->numero }}
                                            </span>
                                            <span class="text-start">
                                                {{ $documento->nome }}
                                            </span>
                                        </div>
                                        <div>
                                            @if ($documento->pivot && !$documento->pivot->aprovado)
                                                <button wire:click="aprovarDocumento('{{ $documento->id }}')" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Aprovar documento">
                                                    <i class="bi bi-clipboard2-check-fill"></i>
                                                </button>
                                            @else
                                                <button wire:click="reprovarDocumento('{{ $documento->id }}')" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Reprovar documento">
                                                    <i class="bi bi-clipboard2-x-fill"></i>
                                                </button>
                                            @endif
                                            <a href="{{ $documento->url }}" target="_blank" class="btn btn-sm btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver documento">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <button wire:click="removeDocument('{{ $documento->id }}')" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Remover documento">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </li>
                                @empty
                                    <li class="list-group-item">Nenhum documento nesta comissão.</li>
                                @endforelse
                                </ul>
                            </div>
                            <div class="col-md-12 mt-4">
                                <h6>Documentos Produzidos</h6>
                                <ul class="list-group">
                                    @forelse ($producedDocuments as $documento)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="badge bg-primary">
                                                    Doc. Nº {{ $documento->numero }}
                                                </span>
                                                <span class="text-start">
                                                    {{ $documento->nome }}
                                                </span>
                                            </div>
                                            
                                            <div>
                                                <a href="{{ $documento->url }}" target="_blank" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="list-group-item">Nenhum documento produzido nesta comissão.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                        <button wire:click="$set('comissaoToManageDocuments', null)" class="btn btn-secondary mt-3">Fechar</button>
                    </div>
                </div>
            @endif
        </div>
    </div>
    
</div>