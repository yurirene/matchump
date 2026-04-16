<div class="mx-auto max-w-lg">
    <h1 class="text-3xl font-bold text-heart-foreground">Descoberta</h1>
    <p class="mt-1 text-sm text-heart-muted-foreground">Um perfil por vez — interessado ou pular.</p>

    @if($row)
        @php $u = $row['user']; @endphp
        <div class="mt-10 overflow-hidden rounded-2xl border border-heart-border bg-heart-card shadow-heart" wire:key="disc-{{ $u->id }}">
            <div class="aspect-[4/3] max-h-72 w-full bg-heart-muted sm:aspect-auto sm:max-h-none sm:h-72">
                @if($u->avatar_path)
                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($u->avatar_path) }}" alt="" class="h-full w-full object-cover">
                @else
                    <div class="flex h-full w-full items-center justify-center text-6xl font-bold text-heart-muted-foreground/50">{{ \Illuminate\Support\Str::substr($u->name, 0, 1) }}</div>
                @endif
            </div>
            <div class="p-6 text-center">
                <h2 class="text-2xl font-bold text-heart-foreground">{{ $u->name }}</h2>
                <p class="text-sm text-heart-muted-foreground">{{ $u->age() }} anos</p>
                <p class="mt-3 text-4xl font-bold text-heart-primary">{{ number_format($row['percent'], 1) }}%</p>
                <p class="text-sm font-medium text-heart-foreground/80">{{ $row['badge'] }}</p>

                <div class="mt-8 flex justify-center gap-6">
                    <button type="button" wire:click="skip('{{ $u->id }}')" class="flex h-14 w-14 items-center justify-center rounded-full border-2 border-heart-border bg-white text-xl shadow-sm transition hover:bg-heart-muted" title="Pular">
                        ✕
                    </button>
                    <button type="button" wire:click="interested('{{ $u->id }}')" class="flex h-14 w-14 items-center justify-center rounded-full bg-heart-primary text-xl text-heart-primary-foreground shadow-md transition hover:opacity-95" title="Interessado">
                        👍
                    </button>
                </div>
            </div>
        </div>
    @else
        <div class="mt-12 rounded-2xl border border-dashed border-heart-border bg-heart-card py-14 text-center text-heart-muted-foreground">
            Não há mais perfis por agora.
        </div>
    @endif
</div>
