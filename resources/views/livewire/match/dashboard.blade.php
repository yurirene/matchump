<div>
    @if(session('status'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">{{ session('status') }}</div>
    @endif

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-heart-foreground">Olá, {{ $user->name }}</h1>
        <p class="mt-1 text-heart-muted-foreground">Explore o questionário, veja matches e use a descoberta.</p>
    </div>

    <div class="grid gap-6 sm:grid-cols-2">
        <div class="rounded-2xl border border-heart-border bg-heart-card p-6 shadow-sm transition hover:shadow-md">
            <h2 class="text-lg font-semibold text-heart-foreground">Questionário</h2>
            <p class="mt-2 text-sm text-heart-muted-foreground">{{ $respondidas }} de {{ $totalPerguntas }} perguntas</p>
            @if($completo)
                <span class="mt-4 inline-flex rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-semibold text-emerald-800">Completo</span>
            @else
                <a href="{{ route('match.questionario') }}" class="mt-4 inline-flex rounded-xl bg-heart-primary px-4 py-2.5 text-sm font-semibold text-heart-primary-foreground shadow-sm hover:opacity-95">Continuar</a>
            @endif
        </div>
        <div class="rounded-2xl border border-heart-border bg-heart-card p-6 shadow-sm transition hover:shadow-md">
            <h2 class="text-lg font-semibold text-heart-foreground">Compatibilidade</h2>
            <p class="mt-2 text-sm text-heart-muted-foreground">Matches com filtro inteligente e explicação do porquê.</p>
            <a href="{{ route('match.matches') }}" class="mt-4 inline-flex rounded-xl border-2 border-heart-primary/30 bg-white px-4 py-2.5 text-sm font-semibold text-heart-primary hover:bg-heart-accent/50">Ver matches</a>
        </div>
        <div class="rounded-2xl border border-heart-border bg-heart-card p-6 shadow-sm transition hover:shadow-md sm:col-span-2">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-heart-foreground">Descoberta</h2>
                    <p class="mt-1 text-sm text-heart-muted-foreground">Um perfil por vez — interessado ou pular.</p>
                </div>
                <a href="{{ route('match.discovery') }}" class="inline-flex shrink-0 justify-center rounded-xl bg-heart-foreground px-4 py-2.5 text-sm font-semibold text-white hover:opacity-90">Abrir descoberta</a>
            </div>
        </div>
    </div>
</div>
