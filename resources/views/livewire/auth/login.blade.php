<form wire:submit.prevent="authenticate">
    <h5 class="card-title text-center mb-3">Faça login para continuar</h5>

    @if (session('status'))
        <div class="alert alert-success mb-3" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input wire:model.defer="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required autofocus autocomplete="username">
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Senha</label>
        <input wire:model.defer="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="current-password">
        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3 form-check">
        <input wire:model.defer="remember" type="checkbox" class="form-check-input" id="remember_me" name="remember">
        <label class="form-check-label" for="remember_me">Lembrar-me</label>
    </div>

    <div class="d-grid gap-2"> {{-- Usa d-grid para que o botão ocupe toda a largura --}}
        <button type="submit" class="btn btn-primary">Entrar</button>
    </div>

    <div class="text-center mt-3">
        @if (Route::has('password.request'))
            <a class="text-decoration-none" href="{{ route('password.request') }}">Esqueceu sua senha?</a>
        @endif
    </div>
    <div class="text-center mt-2">
        <a class="text-decoration-none" href="{{ route('register') }}">Não tem conta? Registre-se</a>
    </div>
</form>