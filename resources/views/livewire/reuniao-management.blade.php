<div>
    @if (session()->has('reuniao-message'))
    <div class="alert alert-success">{{ session('reuniao-message') }}</div>
    @endif
    @if (session()->has('reuniao-context'))
    <div class="alert alert-info">{{ session('reuniao-context') }}</div>
    @endif
    @if (session()->has('reuniao-error'))
    <div class="alert alert-danger">{{ session('reuniao-error') }}</div>
    @endif

    <button wire:click="newReuniao" class="btn btn-success mb-4">
        <i class="bi bi-plus-circle"></i> Nova Reunião
    </button>

    @if ($showForm)
    <div class="card mb-4">
        <div class="card-header">
            <h5>{{ $editing ? 'Editar Reunião' : 'Cadastrar Nova Reunião' }}</h5>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="saveReuniao">
                <div class="mb-3">
                    <label for="ano" class="form-label">Ano da Reunião</label>
                    <input wire:model.defer="ano" type="number" class="form-control @error('ano') is-invalid @enderror" id="ano">
                    @error('ano') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="btn btn-primary">Salvar</button>
                <button type="button" wire:click="resetForm" class="btn btn-secondary ms-2">Cancelar</button>
            </form>
        </div>
    </div>
    @endif

    <h5 class="mt-4">Reuniões Existentes</h5>
    @if ($reunioes->isEmpty())
    <p>Nenhuma reunião encontrada. Cadastre uma nova para começar.</p>
    @else
    <div class="list-group">
        @foreach ($reunioes as $reuniao)
        <li class="list-group-item d-flex justify-content-between align-items-center {{ $reuniao->id === $selectedReuniaoId ? 'active' : '' }}">
            <div>
                <span class="fw-bold">{{ $reuniao->ano }} - {{ $reuniao->codigo }}</span>
                @if ($reuniao->id === $selectedReuniaoId)
                <span class="badge bg-light text-dark ms-2">Selecionada</span>
                @endif
            </div>
            <div>
                <button wire:click="selectReuniao('{{ $reuniao->id }}')" class="btn btn-sm btn-{{ $reuniao->id === $selectedReuniaoId ? 'light' : 'info' }} me-2" {{ $reuniao->id === $selectedReuniaoId ? 'disabled' : '' }}>
                    Selecionar
                </button>
                <button wire:click="editReuniao('{{ $reuniao->id }}')" class="btn btn-sm btn-warning me-2">Editar</button>
                <button wire:click="encerrarReuniao('{{ $reuniao->id }}')" onclick="confirm('Tem certeza que deseja encerrar a reunião?') || event.stopImmediatePropagation()" class="btn btn-sm btn-danger">
                    Encerrar
                </button>
            </div>
        </li>
        @endforeach
    </div>
    @endif
</div>