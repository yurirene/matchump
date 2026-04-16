<div>
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-heart-foreground">Seus matches</h1>
            <p class="mt-1 text-sm text-heart-muted-foreground">Ordenados por compatibilidade (filtro: mesma resposta na pergunta 20 e convergência nas perguntas 4–6). O percentual combina modelo de relacionamento e de amizade cristã.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-sm text-heart-muted-foreground">Ordenar</span>
            <select wire:model.live="ordenacao" class="rounded-xl border border-heart-border bg-white px-3 py-2 text-sm font-medium text-heart-foreground shadow-sm focus:border-heart-primary focus:outline-none focus:ring-2 focus:ring-heart-primary/20">
                <option value="compatibilidade">Compatibilidade</option>
                <option value="idade">Idade</option>
                <option value="nome">Nome</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse($lista as $row)
            @php
                $u = $row['user'];
                $score = $row['percent'];
                $badgeClass = match (true) {
                    $score >= 75 => 'bg-emerald-500/15 text-emerald-800',
                    $score >= 60 => 'bg-amber-500/15 text-amber-900',
                    $score >= 40 => 'bg-orange-500/15 text-orange-900',
                    default => 'bg-heart-muted text-heart-muted-foreground',
                };
            @endphp
            <a href="{{ route('match.detalhe', $u) }}" wire:key="match-{{ $u->id }}" class="group block rounded-2xl border border-heart-border bg-heart-card shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-heart">
                <div class="p-5">
                    <div class="mb-3 flex items-start justify-between gap-3">
                        <div class="h-20 w-20 shrink-0 overflow-hidden rounded-xl bg-heart-muted object-cover ring-2 ring-transparent transition group-hover:ring-heart-primary/30">
                            @if($u->avatar_path)
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($u->avatar_path) }}" alt="" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full w-full items-center justify-center text-2xl font-bold text-heart-muted-foreground">{{ \Illuminate\Support\Str::substr($u->name, 0, 1) }}</div>
                            @endif
                        </div>
                        <span class="shrink-0 rounded-full px-2.5 py-1 text-xs font-semibold {{ $badgeClass }}">{{ number_format($score, 0) }}%</span>
                    </div>
                    <h2 class="text-xl font-semibold text-heart-foreground group-hover:text-heart-primary">{{ $u->name }}</h2>
                    <p class="mt-1 flex items-center gap-1.5 text-sm text-heart-muted-foreground">
                        <span aria-hidden="true">📅</span> {{ $u->age() }} anos · {{ $u->sexoLabel() }}
                    </p>
                    @if(!empty($row['reasons']))
                        <p class="mt-3 line-clamp-2 text-xs text-heart-muted-foreground">{{ $row['reasons'][0] }}</p>
                    @endif
                </div>
            </a>
        @empty
            <div class="col-span-full rounded-2xl border border-dashed border-heart-border bg-heart-card py-16 text-center">
                <p class="text-heart-muted-foreground">Nenhum match encontrado. Complete o questionário ou aguarde mais perfis.</p>
                <a href="{{ route('match.questionario') }}" class="mt-4 inline-flex rounded-xl bg-heart-primary px-4 py-2 text-sm font-semibold text-heart-primary-foreground">Ir ao questionário</a>
            </div>
        @endforelse
    </div>
</div>
