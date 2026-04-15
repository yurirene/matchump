<div class="container mt-4">
    @section('title', 'Documentos')
    <div class="card shadow-sm">
        <div class="card-body">
            @if (session()->has('documento-message'))
                <div class="alert alert-success">{{ session('documento-message') }}</div>
            @endif
            @if (session()->has('documento-error'))
                <div class="alert alert-danger">{{ session('documento-error') }}</div>
            @endif

            <button wire:click="newDocumento" class="btn btn-success mb-4">
                <i class="bi bi-plus-circle"></i>
                Novo Documento
            </button>

            @if ($showForm)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>{{ $editing ? 'Editar Documento' : 'Criar Novo Documento' }}</h5>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="saveDocumento">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="nome" class="form-label">Nome do Documento</label>
                                    <input wire:model.defer="nome" type="text" class="form-control @error('nome') is-invalid @enderror" id="nome">
                                    @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label for="numero" class="form-label">Número do Documento</label>
                                    <input wire:model.defer="numero" type="number" class="form-control @error('numero') is-invalid @enderror" id="numero" min="1">
                                    @error('numero') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label for="tipo" class="form-label">Tipo de Documento</label>
                                    <select wire:model.live="tipo" id="tipo" class="form-select @error('tipo') is-invalid @enderror">
                                        <option value="">Selecione o Tipo</option>
                                        @foreach ($tiposDocumento as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('tipo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row">

                                <div class="mb-3 col-md-6">
                                    <label for="url" class="form-label">URL do Arquivo</label>
                                    <input wire:model.defer="url" type="url" class="form-control @error('url') is-invalid @enderror" id="url">
                                    @error('url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                @if($exibirDelegado)
                                <div class="mb-3 col-md-6">
                                    <label for="delegado_id" class="form-label">Delegado (Opcional)</label>
                                    <select wire:model.defer="delegado_id" id="delegado_id" class="form-select @error('delegado_id') is-invalid @enderror">
                                        <option value="">Nenhum Delegado</option>
                                        @foreach ($delegadosDisponiveis as $delegado)
                                            <option value="{{ $delegado->id }}">{{ $delegado->nome }} ({{ $delegado->unidade->nome ?? 'N/A' }})</option>
                                        @endforeach
                                    </select>
                                    @error('delegado_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                @endif

                                @if($exibirComissao)
                                <div class="mb-3 col-md-6">
                                    <label for="comissao_id" class="form-label">Comissão (Opcional)</label>
                                    <select wire:model.defer="comissao_id" id="comissao_id" class="form-select @error('comissao_id') is-invalid @enderror">
                                        <option value="">Nenhuma Comissão</option>
                                        @foreach ($comissoesDisponiveis as $comissao)
                                            <option value="{{ $comissao->id }}">{{ $comissao->nome }}</option>
                                        @endforeach
                                    </select>
                                    @error('comissao_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                @endif

                                @if($exibirUnidade)
                                <div class="mb-3 col-md-6">
                                    <label for="unidade_id" class="form-label">Unidade (Opcional)</label>
                                    <select wire:model.defer="unidade_id" id="unidade_id" class="form-select @error('unidade_id') is-invalid @enderror">
                                        <option value="">Nenhuma Unidade</option>
                                        @foreach ($unidadesDisponiveis as $unidade)
                                            <option value="{{ $unidade->id }}">{{ $unidade->nome }}</option>
                                        @endforeach
                                    </select>
                                    @error('unidade_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                            <button type="button" wire:click="resetForm" class="btn btn-secondary ms-2">Cancelar</button>
                        </form>
                    </div>
                </div>
            @endif

            <h5 class="mt-4">Documentos Cadastrados</h5>
            @if ($documentos->isEmpty())
                <p>Nenhum documento encontrado para a reunião selecionada.</p>
            @else
                <div class="table-responsive" style="min-height: 300px;">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Número</th>
                                <th>Tipo</th>
                                <th>URL</th>
                                <th>Origem</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documentos as $documento)
                                <tr>
                                    <td>{{ $documento->nome }}</td>
                                    <td>{{ $documento->numero }}</td>
                                    <td>{{ $documento->tipo->label() }}</td>
                                    <td><a href="{{ $documento->url }}" target="_blank" class="btn btn-sm btn-outline-primary">Ver</a></td>
                                    <td>
                                        @if ($documento->delegado) Delegado: {{ $documento->delegado->nome }}
                                        @elseif ($documento->comissao) Comissão: {{ $documento->comissao->nome }}
                                        @elseif ($documento->unidade) Unidade: {{ $documento->unidade->nome }}
                                        @else N/A
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $documento->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                Ações
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $documento->id }}">
                                                <li>
                                                    <a class="dropdown-item" href="#" wire:click.prevent="editDocumento('{{ $documento->id }}')">
                                                        <i class="bi bi-pencil-square me-2"></i>
                                                        Editar
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="#" wire:click.prevent="deleteDocumento('{{ $documento->id }}')" onclick="confirm('Tem certeza?') || event.stopImmediatePropagation()">
                                                        <i class="bi bi-trash me-2"></i>
                                                        Excluir
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