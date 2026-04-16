@php
    $bdLabels = [
        'valores_espirituais' => 'Valores espirituais',
        'objetivos_vida' => 'Objetivos de vida',
        'apego_emocional' => 'Apego emocional',
        'comunicacao' => 'Comunicação',
        'personalidade' => 'Personalidade',
        'estilo_vida' => 'Estilo de vida',
        'relacionamento_prioridades' => 'Prioridades no relacionamento',
        'espaco_pessoal' => 'Espaço pessoal',
        'amizade_crista' => 'Amizade cristã (agregado)',
    ];
    $abaLabels = [
        'valores' => 'Fé, valores e metas',
        'personalidade' => 'Convívio e personalidade',
        'estilo' => 'Rotina, igreja e comunicação',
    ];
@endphp

<div class="mx-auto max-w-5xl">
    <a href="{{ route('match.matches') }}" class="mb-6 inline-flex items-center gap-2 text-sm font-medium text-heart-muted-foreground hover:text-heart-primary">
        ← Voltar aos matches
    </a>

    <div class="overflow-hidden rounded-2xl border border-heart-border bg-heart-card shadow-sm">
        <div class="p-6 sm:p-8">
            <div class="flex flex-col gap-6 md:flex-row">
                <div class="h-32 w-32 shrink-0 overflow-hidden rounded-2xl bg-heart-muted">
                    @if($alvo->avatar_path)
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($alvo->avatar_path) }}" alt="" class="h-full w-full object-cover">
                    @else
                        <div class="flex h-full w-full items-center justify-center text-4xl font-bold text-heart-muted-foreground">{{ \Illuminate\Support\Str::substr($alvo->name, 0, 1) }}</div>
                    @endif
                </div>
                <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <h1 class="text-3xl font-bold text-heart-foreground">{{ $alvo->name }}</h1>
                        @php $pct = $resultado['percent']; @endphp
                        <span class="rounded-full px-4 py-1 text-lg font-bold {{ $pct >= 75 ? 'bg-emerald-500/15 text-emerald-800' : ($pct >= 60 ? 'bg-amber-500/15 text-amber-900' : ($pct >= 40 ? 'bg-orange-500/15 text-orange-900' : 'bg-heart-muted text-heart-muted-foreground')) }}">
                            {{ number_format($pct, 1) }}%
                        </span>
                    </div>
                    <p class="mt-2 text-sm text-heart-muted-foreground">📅 {{ $alvo->age() }} anos · {{ $alvo->sexoLabel() }}</p>
                    <p class="mt-2 inline-flex rounded-full bg-heart-accent px-3 py-1 text-xs font-semibold text-heart-accent-foreground">{{ $resultado['badge'] }}</p>
                    @if(!empty($resultado['reasons']))
                        <ul class="mt-4 list-inside list-disc space-y-1 text-sm text-heart-muted-foreground">
                            @foreach($resultado['reasons'] as $r)
                                <li>{{ $r }}</li>
                            @endforeach
                        </ul>
                    @elseif($pct <= 0)
                        <p class="mt-4 text-sm text-heart-muted-foreground">Sem compatibilidade nos filtros atuais: é preciso o mesmo “O que você busca hoje” (pergunta 20) e pelo menos um alinhamento nas perguntas 4, 5 e 6 (vida espiritual e fé).</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(!empty($resultado['breakdown']))
        <div class="mt-6 overflow-hidden rounded-2xl border border-heart-border bg-heart-card p-6 shadow-sm sm:p-8">
            <h2 class="text-xl font-semibold text-heart-foreground">Detalhamento</h2>
            <div class="mt-6 grid gap-6 sm:grid-cols-2">
                @foreach($resultado['breakdown'] as $key => $val)
                    <div>
                        <div class="mb-2 flex items-center justify-between text-sm">
                            <span class="font-medium text-heart-foreground">{{ $bdLabels[$key] ?? $key }}</span>
                            <span class="font-semibold text-heart-primary">{{ number_format((float) $val, 0) }}%</span>
                        </div>
                        <div class="h-2 w-full overflow-hidden rounded-full bg-heart-muted">
                            <div class="h-full rounded-full bg-heart-primary transition-all" style="width: {{ min(100, max(0, (float) $val)) }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="mt-6 overflow-hidden rounded-2xl border border-heart-border bg-heart-card p-6 shadow-sm sm:p-8">
        <h2 class="text-xl font-semibold text-heart-foreground">Comparativo de respostas</h2>
        <p class="mt-1 text-sm text-heart-muted-foreground">Suas respostas x {{ $alvo->name }}</p>

        <div class="mt-6 flex flex-wrap gap-2 border-b border-heart-border pb-4">
            @foreach(['valores', 'personalidade', 'estilo'] as $slug)
                <button type="button" wire:click="$set('aba', '{{ $slug }}')" class="rounded-lg px-3 py-2 text-sm font-medium transition {{ $aba === $slug ? 'bg-heart-primary text-heart-primary-foreground' : 'text-heart-muted-foreground hover:bg-heart-muted' }}">
                    {{ $abaLabels[$slug] }}
                </button>
            @endforeach
        </div>

        <div class="mt-6 space-y-4">
            @foreach($comparacoes->filter(fn ($c) => $c['slug'] === $aba) as $item)
                <div class="rounded-xl border p-4 {{ $item['igual'] ? 'border-emerald-200 bg-emerald-50/60' : 'border-heart-border bg-heart-muted/30' }}">
                    <p class="text-sm font-medium text-heart-foreground">{{ $item['texto'] }}</p>
                    <div class="mt-3 grid gap-4 sm:grid-cols-2">
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-heart-muted-foreground">Você</p>
                            <p class="mt-1 inline-block rounded-lg bg-white px-3 py-1.5 text-sm text-heart-foreground ring-1 ring-heart-border">{{ $item['viewer_label'] }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-heart-muted-foreground">{{ $alvo->name }}</p>
                            <p class="mt-1 inline-block rounded-lg bg-white px-3 py-1.5 text-sm text-heart-foreground ring-1 ring-heart-border">{{ $item['alvo_label'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
