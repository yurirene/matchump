<x-app-layout>
    <div class="container mt-5 text-center">
        <h2>Confirme seu email</h2>
        <p>Enviamos um link de verificação para <strong>{{ auth()->user()->email }}</strong>.</p>
        <p>Antes de continuar, clique no link que enviamos. Se não recebeu, clique no botão abaixo para reenviar.</p>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success mt-3">
                Um novo link de verificação foi enviado para seu email.
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary mt-3">Reenviar link de verificação</button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="btn btn-secondary">Sair</button>
        </form>
    </div>
</x-app-layout>