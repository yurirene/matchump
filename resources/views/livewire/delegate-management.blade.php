<div class="container mt-4">
    @section('title', 'Delegados')
    <div class="card shadow-sm">
        <div class="card-body">
            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <button wire:click="newDelegate" class="btn btn-success mb-4">
                <i class="bi bi-plus-circle"></i> Novo Delegado
            </button>

            @if ($showForm)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>{{ $editing ? 'Editar Delegado' : 'Cadastrar Novo Delegado' }}</h5>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="saveDelegate">
                            @if (Auth::user()->isSinodal())
                                <div class="mb-3">
                                    <label for="unidade_id" class="form-label">Unidade (Federação/UMP)</label>
                                    <select wire:model.live="unidade_id" id="unidade_id" class="form-select @error('unidade_id') is-invalid @enderror">
                                        <option value="">Selecione uma Unidade</option>
                                        @foreach ($unidades as $unidade)
                                            <option value="{{ $unidade->id }}">{{ $unidade->nome }}</option>
                                        @endforeach
                                    </select>
                                    @error('unidade_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            @else
                                <div class="mb-3">
                                    <label class="form-label">Unidade Associada</label>
                                    <input type="text" class="form-control" value="{{ $unidades->first()->nome ?? 'N/A' }}" disabled>
                                    <input type="hidden" wire:model="unidade_id">
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome Completo</label>
                                <input wire:model.defer="nome" type="text" class="form-control @error('nome') is-invalid @enderror" id="nome">
                                @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="cpf" class="form-label">CPF (apenas números)</label>
                                <input wire:model.blur="cpf" type="text" class="form-control @error('cpf') is-invalid @enderror" id="cpf" maxlength="11" pattern="\d{11}" title="Apenas 11 números">
                                @error('cpf') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="telefone" class="form-label">Telefone (DDD + Telefone)</label>
                                <input wire:model.defer="telefone" type="text" class="form-control @error('telefone') is-invalid @enderror" id="telefone">
                                @error('telefone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="cargo" class="form-label">Cargo (Opcional)</label>
                                <select wire:model.defer="cargo" id="cargo" class="form-select @error('cargo') is-invalid @enderror">
                                    <option value="">Selecione</option>
                                    @foreach ($cargos as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('cargo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tipo" class="form-label">Tipo de Delegado</label>
                                <select wire:model.defer="tipo" id="tipo" class="form-select @error('tipo') is-invalid @enderror">
                                    @foreach ($tiposDelegado as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('tipo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="url_credencial" class="form-label">URL da Credencial (Opcional)</label>
                                <input wire:model.defer="url_credencial" type="url" class="form-control @error('url_credencial') is-invalid @enderror" id="url_credencial">
                                @error('url_credencial') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3 form-check form-switch">
                                <input wire:model.defer="status" class="form-check-input" type="checkbox" id="status">
                                <label class="form-check-label" for="status">Delegado Ativo</label>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="saveDelegate">
                                    <i class="bi bi-floppy"></i> Salvar
                                </span>
                                <span wire:loading wire:target="saveDelegate">
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

            <h5 class="mt-4">Delegados Cadastrados</h5>

            @if (Auth::user()->isSinodal())
                <div class="mb-3">
                    <label for="filterUnidadeId" class="form-label">Filtrar por Unidade</label>
                    <select wire:model.live="selectedUnidadeId" id="filterUnidadeId" class="form-select">
                        <option value="">Todas as Unidades</option>
                        @foreach ($unidades as $unidade)
                            <option value="{{ $unidade->id }}">{{ $unidade->nome }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if ($delegados->isEmpty())
                <p>Nenhum delegado encontrado para esta seleção.</p>
            @else
                <div class="table-responsive" style="min-height: 500px;">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Unidade</th>
                                <th>Cargo</th>
                                <th>Tipo</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($delegados as $delegado)
                                <tr>
                                    <td>{{ $delegado->nome }}</td>
                                    <td>{{ $delegado->cpf }}</td>
                                    <td>{{ $delegado->unidade->nome ?? 'N/A' }}</td>
                                    <td>{{ $delegado->cargo?->label() ?? 'N/A' }}</td>
                                    <td>{{ $delegado->tipo?->label() ?? 'N/A' }}</td>
                                    <td>
                                        @if ($delegado->status)
                                            <span class="badge bg-success">Ativo</span>
                                        @else
                                            <span class="badge bg-danger">Inativo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $delegado->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $delegado->id }}">
                                                <li>
                                                    <a class="dropdown-item" href="#" wire:click.prevent="editDelegate('{{ $delegado->id }}')">
                                                        <i class="bi bi-pencil-square me-2"></i>Editar
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="#" onclick="confirm('Tem certeza que deseja excluir este delegado?') || event.stopImmediatePropagation(); @this.deleteDelegate('{{ $delegado->id }}')">
                                                        <i class="bi bi-trash me-2"></i>Excluir
                                                    </a>
                                                </li>
                                                @if ($delegado->url_credencial)
                                                    <li>
                                                        <a class="dropdown-item" href="{{ $delegado->url_credencial }}" target="_blank" rel="noopener noreferrer">
                                                            <i class="bi bi-box-arrow-up-right me-2"></i>Abrir Credencial
                                                        </a>
                                                    </li>
                                                @endif
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