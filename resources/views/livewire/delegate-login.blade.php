<div class="d-flex align-items-center justify-content-center vh-100">
        <div class="card shadow-sm p-4 rounded-3" style="width: 100%; max-width: 400px;">
            <div class="card-body">
                <h5 class="card-title text-center mb-4">Login de Delegados</h5>

                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                
                <form wire:submit.prevent="login">
                    <div class="mb-3">
                        <label for="codigo_reuniao" class="form-label">Código da Reunião</label>
                        <input wire:model="codigo_reuniao" type="text" class="form-control codigo_reuniao @error('codigo_reuniao') is-invalid @enderror" id="codigo_reuniao">
                        @error('codigo_reuniao') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="cpf" class="form-label">CPF</label>
                        <input wire:model="cpf" type="text" class="form-control cpf @error('cpf') is-invalid @enderror" id="cpf">
                        @error('cpf') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Entrar</button>
                    </div>
                </form>
                <div class="text-center mt-3">
                    <a href="{{ route('home') }}">Voltar</a>
                </div>
            </div>
        </div>
    </div>