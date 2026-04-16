<div class="mx-auto max-w-3xl">
    <div class="overflow-hidden rounded-2xl border border-heart-border bg-heart-card shadow-sm">
        <div class="border-b border-heart-border p-6 sm:p-8">
            <div class="flex flex-col gap-6 md:flex-row md:items-start">
                <div class="h-32 w-32 shrink-0 overflow-hidden rounded-2xl bg-heart-muted ring-2 ring-heart-primary/10">
                    @if($user->avatar_path)
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($user->avatar_path) }}" alt="" class="h-full w-full object-cover">
                    @else
                        <div class="flex h-full w-full items-center justify-center text-4xl font-bold text-heart-muted-foreground">{{ \Illuminate\Support\Str::substr($user->name, 0, 1) }}</div>
                    @endif
                </div>
                <div class="min-w-0 flex-1">
                    <h1 class="text-3xl font-bold text-heart-foreground">{{ $user->name }}</h1>
                    <p class="mt-2 flex flex-wrap gap-4 text-sm text-heart-muted-foreground">
                        <span>📅 {{ $user->age() }} anos</span>
                        <span>{{ $user->sexoLabel() }}</span>
                        <span>{{ $user->email }}</span>
                    </p>
                </div>
            </div>
            <div class="mt-6 flex flex-col gap-3 border-t border-heart-border pt-6 sm:flex-row">
                <a href="{{ route('match.matches') }}" class="inline-flex flex-1 items-center justify-center rounded-xl bg-heart-primary px-4 py-3 text-sm font-semibold text-heart-primary-foreground shadow-sm hover:opacity-95">Ver matches</a>
                <a href="{{ route('match.questionario') }}" class="inline-flex flex-1 items-center justify-center rounded-xl border border-heart-border bg-white px-4 py-3 text-sm font-semibold text-heart-foreground hover:bg-heart-muted/50">Editar respostas</a>
            </div>
        </div>
    </div>

    @if(session('status'))
        <div class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">{{ session('status') }}</div>
    @endif

    <div class="mt-8 rounded-2xl border border-heart-border bg-heart-card p-6 shadow-sm sm:p-8">
        <h2 class="text-lg font-semibold text-heart-foreground">Dados da conta</h2>
        <p class="mt-1 text-sm text-heart-muted-foreground">Atualize nome, data de nascimento ou foto.</p>

        <form wire:submit="save" class="mt-6 space-y-4">
            <div>
                <label class="mb-1.5 block text-sm font-medium text-heart-foreground">Nome</label>
                <input type="text" wire:model="name" class="w-full rounded-xl border border-heart-border bg-white px-3 py-2.5 text-sm shadow-sm focus:border-heart-primary focus:outline-none focus:ring-2 focus:ring-heart-primary/20">
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-heart-foreground">Data de nascimento</label>
                <input type="date" wire:model="birth_date" class="w-full rounded-xl border border-heart-border bg-white px-3 py-2.5 text-sm shadow-sm focus:border-heart-primary focus:outline-none focus:ring-2 focus:ring-heart-primary/20">
                @error('birth_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <fieldset>
                <legend class="mb-1.5 block text-sm font-medium text-heart-foreground">Sexo</legend>
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
                @error('sexo') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </fieldset>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-heart-foreground">Nova foto</label>
                <input type="file" wire:model="avatar" accept="image/*" class="w-full text-sm text-heart-muted-foreground file:mr-3 file:rounded-lg file:border-0 file:bg-heart-accent file:px-3 file:py-2 file:text-sm file:font-medium file:text-heart-accent-foreground">
                @error('avatar') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="rounded-xl bg-heart-foreground px-5 py-2.5 text-sm font-semibold text-white hover:opacity-90 disabled:cursor-not-allowed disabled:opacity-60" wire:loading.attr="disabled" wire:target="save,avatar">Salvar alterações</button>
        </form>
    </div>
</div>
