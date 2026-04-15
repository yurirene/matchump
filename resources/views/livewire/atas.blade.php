<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            @if (session()->has('ata-message'))
                <div class="alert alert-success">{{ session('ata-message') }}</div>
            @endif

            @if (session()->has('reuniao-error'))
                <div class="alert alert-warning">{{ session('reuniao-error') }}</div>
            @elseif (!$reuniaoAtivaId)
                <p>Por favor, selecione uma reunião para gerenciar as atas.</p>
            @else
            <button type="button" wire:click="toggleForm" class="btn btn-success mb-3">
                <i class="bi bi-plus-circle"></i> Nova Ata
            </button>
            @if($showForm)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">{{ $isEditing ? 'Editar Ata' : 'Nova Ata' }}</h5>
                </div>

                <form wire:submit.prevent="saveAta" class="mb-5">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nome" class="form-label">Nome da Ata <span class="text-danger">*</span></label>
                            <input 
                                wire:model="nome" 
                                type="text" 
                                class="form-control @error('nome') is-invalid @enderror" 
                                id="nome"
                                placeholder="Ata Nº">
                            @error('nome') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="sessao" class="form-label">Sessão <span class="text-danger">*</span></label>
                            <select 
                                wire:model="sessaoId" 
                                class="form-select @error('sessaoId') is-invalid @enderror" 
                                id="sessao">
                                <option value="">Selecione uma Sessão</option>
                                @foreach ($sessoes as $sessao)
                                    <option value="{{ $sessao->id }}">{{ $sessao->nome }}</option>
                                @endforeach
                            </select>
                            @error('sessaoId') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                        </div>
                        
                        <div class="col-md-12">
                            <label for="url" class="form-label">URL da Ata <span class="text-danger">*</span></label>
                            <input 
                                wire:model="url" 
                                type="url" 
                                class="form-control @error('url') is-invalid @enderror" 
                                id="url"
                                placeholder="https://exemplo.com/ata.pdf">
                            @error('url') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                        </div>
                        
                        <div class="col-md-12">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-floppy"></i>
                                    Salvar
                                </button>
                                <button type="button" wire:click="toggleForm" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Fechar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
                <h5 class="mb-3">Atas Cadastradas</h5>
                @if ($atas->isEmpty())
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        Nenhuma ata cadastrada para esta reunião.
                    </div>
                @else
                    <div class="table-responsive" style="min-height: 400px;">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Nome</th>
                                    <th>Sessão</th>
                                    <th>Aprovada</th>
                                    <th style="width: 200px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($atas as $ata)
                                    <tr>
                                        <td>
                                            <strong>{{ $ata->nome }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $ata->sessao->nome ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            @if ($ata->aprovada)
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle"></i> Aprovada
                                                </span>
                                            @else
                                                <span class="badge bg-warning">
                                                    <i class="bi bi-clock"></i> Pendente
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $ata->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Ações
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $ata->id }}">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ $ata->url }}" target="_blank">
                                                            <i class="bi bi-eye"></i> Visualizar
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#" wire:click.prevent="toggleAprovada('{{ $ata->id }}')">
                                                            <i class="bi bi-patch-check"></i> Alterar Status
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#" wire:click.prevent="edit('{{ $ata->id }}')">
                                                            <i class="bi bi-pencil"></i> Editar
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#" wire:click.prevent="deleteAta('{{ $ata->id }}')" onclick="confirm('Tem certeza que deseja excluir esta ata?') || event.stopImmediatePropagation()">
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
            @endif
        </div>
    </div>
</div>