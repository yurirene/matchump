<div class="-mx-4 -mt-8 flex min-h-[calc(100dvh-4rem)] flex-col items-center justify-center bg-gradient-to-br from-heart-primary/[0.08] via-heart-background to-heart-accent px-4 py-10 sm:-mx-6 lg:-mx-8">
    <div class="w-full max-w-md overflow-hidden rounded-xl border border-heart-border bg-heart-card shadow-lg">
        {{-- CardHeader (modelo React: ícone + título + descrição) --}}
        <div class="space-y-1 border-b border-heart-border bg-heart-card px-6 pb-6 pt-8 text-center">
            <div class="mb-4 flex justify-center">
                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-heart-primary text-heart-primary-foreground shadow-md">
                    <svg class="h-9 w-9" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                    </svg>
                </div>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-heart-foreground">Bem-vindo de volta</h1>
            <p class="text-sm text-heart-muted-foreground">Entre na sua conta MatchUMP para ver matches e compatibilidade.</p>
        </div>

        {{-- CardContent --}}
        <div class="px-6 py-6">
            <form wire:submit="login" class="space-y-4">
                @if ($errors->any())
                    <div class="flex gap-3 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-800" role="alert">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 8v4M12 16h.01" stroke-linecap="round" />
                        </svg>
                        <div>
                            @foreach ($errors->all() as $err)
                                <p>{{ $err }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="space-y-2">
                    <label for="match-login-email" class="text-sm font-medium leading-none text-heart-foreground">E-mail</label>
                    <input
                        id="match-login-email"
                        type="email"
                        wire:model="email"
                        class="flex h-10 w-full rounded-md border border-heart-border bg-white px-3 py-2 text-sm text-heart-foreground shadow-sm ring-offset-white placeholder:text-heart-muted-foreground focus-visible:border-heart-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-heart-primary/25"
                        placeholder="voce@exemplo.com"
                        required
                        autocomplete="username"
                    >
                </div>

                <div class="space-y-2">
                    <label for="match-login-password" class="text-sm font-medium leading-none text-heart-foreground">Senha</label>
                    <input
                        id="match-login-password"
                        type="password"
                        wire:model="password"
                        class="flex h-10 w-full rounded-md border border-heart-border bg-white px-3 py-2 text-sm text-heart-foreground shadow-sm ring-offset-white placeholder:text-heart-muted-foreground focus-visible:border-heart-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-heart-primary/25"
                        placeholder="Digite sua senha"
                        required
                        autocomplete="current-password"
                    >
                </div>

                <label class="flex cursor-pointer items-center gap-2 text-sm text-heart-muted-foreground">
                    <input type="checkbox" wire:model="remember" class="h-4 w-4 rounded border-heart-border text-heart-primary focus:ring-heart-primary/30">
                    Lembrar-me neste dispositivo
                </label>

                <div class="rounded-lg bg-heart-muted p-3 text-sm">
                    <p class="mb-1.5 text-heart-muted-foreground">Ambiente de teste (após <code class="rounded bg-white/80 px-1 py-0.5 text-xs">php artisan migrate --seed</code>):</p>
                    <p class="font-medium text-heart-foreground">Use um e-mail gerado pelo seeder de <span class="text-heart-primary">match_users</span></p>
                    <p class="font-medium text-heart-foreground">Senha: <span class="select-all">password</span></p>
                </div>

                <button
                    type="submit"
                    class="flex h-10 w-full items-center justify-center rounded-md bg-heart-primary text-sm font-semibold text-heart-primary-foreground shadow transition hover:opacity-95 disabled:cursor-not-allowed disabled:opacity-60"
                    wire:loading.attr="disabled"
                    wire:target="login"
                >
                    <span wire:loading.remove wire:target="login">Entrar</span>
                    <span wire:loading wire:target="login" class="inline-flex items-center gap-2">
                        <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                        </svg>
                        Entrando…
                    </span>
                </button>

                <p class="pt-1 text-center text-sm text-heart-muted-foreground">
                    Não tem conta?
                    <a href="{{ route('register') }}" class="font-medium text-heart-primary underline-offset-4 hover:underline">Criar conta</a>
                </p>
            </form>
        </div>
    </div>
</div>
