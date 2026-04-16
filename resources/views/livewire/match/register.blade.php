<div class="-mx-4 -mt-8 flex min-h-[calc(100dvh-4rem)] flex-col items-center justify-center bg-gradient-to-br from-heart-primary/[0.08] via-heart-background to-heart-accent px-4 py-10 sm:-mx-6 lg:-mx-8">
    <div class="w-full max-w-md overflow-hidden rounded-xl border border-heart-border bg-heart-card shadow-lg">
        {{-- CardHeader --}}
        <div class="space-y-1 border-b border-heart-border bg-heart-card px-6 pb-6 pt-8 text-center">
            <div class="mb-4 flex justify-center">
                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-heart-primary text-heart-primary-foreground shadow-md">
                    <svg class="h-9 w-9" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                    </svg>
                </div>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-heart-foreground">Crie sua conta</h1>
            <p class="text-sm text-heart-muted-foreground">Comece a encontrar conexões com base em compatibilidade (idade 21 a 35 anos).</p>
        </div>

        {{-- CardContent --}}
        <div class="px-6 py-6">
            <form wire:submit="register" class="space-y-4">
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
                    <label for="match-reg-name" class="text-sm font-medium leading-none text-heart-foreground">Nome completo</label>
                    <input
                        id="match-reg-name"
                        type="text"
                        wire:model="name"
                        class="flex h-10 w-full rounded-md border border-heart-border bg-white px-3 py-2 text-sm text-heart-foreground shadow-sm placeholder:text-heart-muted-foreground focus-visible:border-heart-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-heart-primary/25"
                        placeholder="Seu nome"
                        required
                        autocomplete="name"
                    >
                </div>

                <div class="space-y-2">
                    <label for="match-reg-email" class="text-sm font-medium leading-none text-heart-foreground">E-mail</label>
                    <input
                        id="match-reg-email"
                        type="email"
                        wire:model="email"
                        class="flex h-10 w-full rounded-md border border-heart-border bg-white px-3 py-2 text-sm text-heart-foreground shadow-sm placeholder:text-heart-muted-foreground focus-visible:border-heart-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-heart-primary/25"
                        placeholder="seu@email.com"
                        required
                        autocomplete="username"
                    >
                </div>

                <div class="space-y-2">
                    <label for="match-reg-password" class="text-sm font-medium leading-none text-heart-foreground">Senha</label>
                    <input
                        id="match-reg-password"
                        type="password"
                        wire:model="password"
                        class="flex h-10 w-full rounded-md border border-heart-border bg-white px-3 py-2 text-sm text-heart-foreground shadow-sm placeholder:text-heart-muted-foreground focus-visible:border-heart-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-heart-primary/25"
                        placeholder="Mínimo de 8 caracteres"
                        required
                        autocomplete="new-password"
                    >
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="space-y-2 sm:col-span-1">
                        <label for="match-reg-birth" class="text-sm font-medium leading-none text-heart-foreground">Data de nascimento</label>
                        <input
                            id="match-reg-birth"
                            type="date"
                            wire:model="birth_date"
                            class="flex h-10 w-full rounded-md border border-heart-border bg-white px-3 py-2 text-sm text-heart-foreground shadow-sm focus-visible:border-heart-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-heart-primary/25"
                            required
                        >
                    </div>
                    <div class="flex flex-col justify-end rounded-lg border border-dashed border-heart-border bg-heart-muted/50 p-3 text-xs leading-relaxed text-heart-muted-foreground sm:min-h-[4.5rem]">
                        <p class="font-medium text-heart-foreground/80">Faixa etária</p>
                        <p>Só é permitido cadastro entre <strong class="text-heart-primary">21 e 35 anos</strong> (calculado pela data).</p>
                    </div>
                </div>

                <fieldset class="space-y-2">
                    <legend class="text-sm font-medium leading-none text-heart-foreground">Sexo</legend>
                    <p class="text-xs text-heart-muted-foreground">Informação do cadastro pessoal.</p>
                    <div class="flex flex-wrap gap-4">
                        <label class="inline-flex cursor-pointer items-center gap-2 text-sm text-heart-foreground">
                            <input type="radio" wire:model="sexo" value="masculino" class="h-4 w-4 border-heart-border text-heart-primary focus:ring-heart-primary/30">
                            Masculino
                        </label>
                        <label class="inline-flex cursor-pointer items-center gap-2 text-sm text-heart-foreground">
                            <input type="radio" wire:model="sexo" value="feminino" class="h-4 w-4 border-heart-border text-heart-primary focus:ring-heart-primary/30">
                            Feminino
                        </label>
                    </div>
                    @error('sexo') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </fieldset>

                <div class="space-y-2">
                    <label for="match-reg-avatar" class="text-sm font-medium leading-none text-heart-foreground">Foto do perfil <span class="font-normal text-heart-muted-foreground">(opcional)</span></label>
                    <input
                        id="match-reg-avatar"
                        type="file"
                        wire:model="avatar"
                        accept="image/*"
                        class="flex w-full cursor-pointer rounded-md border border-heart-border bg-white px-3 py-2 text-sm text-heart-muted-foreground file:mr-3 file:rounded-md file:border-0 file:bg-heart-accent file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-heart-accent-foreground hover:file:bg-heart-primary/10"
                    >
                    <div wire:loading wire:target="avatar" class="text-xs text-heart-muted-foreground">Carregando arquivo…</div>
                    @if ($avatar)
                        <div class="mt-2 overflow-hidden rounded-lg border border-heart-border bg-heart-muted/30">
                            <img src="{{ $avatar->temporaryUrl() }}" alt="Pré-visualização" class="mx-auto max-h-40 object-contain">
                        </div>
                    @endif
                </div>

                <div class="space-y-2">
                    <label for="match-reg-password2" class="text-sm font-medium leading-none text-heart-foreground">Confirmar senha</label>
                    <input
                        id="match-reg-password2"
                        type="password"
                        wire:model="password_confirmation"
                        class="flex h-10 w-full rounded-md border border-heart-border bg-white px-3 py-2 text-sm text-heart-foreground shadow-sm placeholder:text-heart-muted-foreground focus-visible:border-heart-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-heart-primary/25"
                        placeholder="Repita a senha"
                        required
                        autocomplete="new-password"
                    >
                </div>

                <button
                    type="submit"
                    class="flex h-10 w-full items-center justify-center rounded-md bg-heart-primary text-sm font-semibold text-heart-primary-foreground shadow transition hover:opacity-95 disabled:cursor-not-allowed disabled:opacity-60"
                    wire:loading.attr="disabled"
                    wire:target="register,avatar"
                >
                    <span wire:loading.remove wire:target="register">Criar conta</span>
                    <span wire:loading wire:target="register" class="inline-flex items-center gap-2">
                        <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                        </svg>
                        Criando conta…
                    </span>
                </button>

                <p class="pt-1 text-center text-sm text-heart-muted-foreground">
                    Já tem conta?
                    <a href="{{ route('login') }}" class="font-medium text-heart-primary underline-offset-4 hover:underline">Entrar</a>
                </p>
            </form>
        </div>
    </div>
</div>
