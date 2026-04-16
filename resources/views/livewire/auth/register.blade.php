<form wire:submit.prevent="register">
    <h5 class="card-title text-center mb-3">Registro</h5>

    <div class="mb-3">
        <label for="name" class="form-label">Nome</label>
        <input wire:model.defer="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required autofocus autocomplete="name">
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input wire:model.defer="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required autocomplete="username">
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>


    <div class="mb-3">
        <label for="birth_date" class="form-label">Data de nascimento</label>
        <input wire:model.defer="birth_date" type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" required autocomplete="birth_date">
        @error('birth_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>


    <div class="mb-3">
        <label for="password" class="form-label">Senha</label>
        <input wire:model.defer="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="new-password">
        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirmar Senha</label>
        <input wire:model.defer="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
        @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary">Registrar</button>
    </div>

    <div class="text-center mt-3">
        <a class="text-decoration-none" href="{{ route('diretoria.login') }}">Já tem uma conta? Faça login</a>
    </div>
</form>