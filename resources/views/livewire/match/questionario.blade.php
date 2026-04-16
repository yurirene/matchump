<div class="mx-auto max-w-2xl">
    <h1 class="text-2xl font-bold text-heart-foreground sm:text-3xl">Questionário</h1>
    <p class="mt-1 text-sm text-heart-muted-foreground">Responda com calma. Você pode voltar e editar quando quiser.</p>

    @if($atual)
        <div class="mt-8">
            <div class="mb-2 flex items-center justify-between text-sm">
                <span class="font-medium text-heart-muted-foreground">Pergunta {{ $step + 1 }} de {{ $total }}</span>
                <span class="font-semibold text-heart-primary">{{ $progress }}%</span>
            </div>
            <div class="h-2 w-full overflow-hidden rounded-full bg-heart-muted">
                <div class="h-full rounded-full bg-heart-primary transition-all duration-300" style="width: {{ $progress }}%"></div>
            </div>
        </div>

        <div class="mt-8 rounded-2xl border border-heart-border bg-heart-card p-6 shadow-sm sm:p-8">
            <p class="text-xs font-semibold uppercase tracking-wide text-heart-primary">{{ $categoriaAtual }}</p>
            <h2 class="mt-2 text-xl font-semibold leading-snug text-heart-foreground sm:text-2xl">{{ $atual->texto }}</h2>

            <div class="mt-6 space-y-3">
                @foreach($atual->opcoes as $key => $label)
                    @php $letter = is_string($key) && strlen($key) === 1 ? $key : chr(65 + (int) $key); @endphp
                    <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-heart-border p-4 transition-all hover:border-heart-primary/40 hover:bg-heart-accent/40 has-[:checked]:border-heart-primary has-[:checked]:bg-heart-accent/60" wire:key="opt-{{ $atual->id }}-{{ $letter }}">
                        <input type="radio" class="mt-1 h-4 w-4 border-heart-border text-heart-primary focus:ring-heart-primary/30" name="opt-{{ $atual->id }}" value="{{ $letter }}" wire:model.live="answers.{{ $atual->id }}">
                        <span class="text-sm leading-relaxed text-heart-foreground sm:text-base"><span class="font-semibold text-heart-primary">{{ $letter }}.</span> {{ $label }}</span>
                    </label>
                @endforeach
            </div>

            @error('answers')
                <p class="mt-4 rounded-lg bg-red-50 px-3 py-2 text-sm text-red-700">{{ $message }}</p>
            @enderror

            <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-between">
                <button type="button" wire:click="previous" @if($step === 0) disabled @endif class="inline-flex items-center justify-center gap-2 rounded-xl border border-heart-border bg-white px-4 py-3 text-sm font-medium text-heart-foreground shadow-sm transition hover:bg-heart-muted disabled:cursor-not-allowed disabled:opacity-40">
                    <span aria-hidden="true">←</span> Voltar
                </button>
                <div class="flex gap-3 sm:justify-end">
                    @if($step < $total - 1)
                        <button type="button" wire:click="next" class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-heart-primary px-4 py-3 text-sm font-semibold text-heart-primary-foreground shadow-sm transition hover:opacity-95 sm:flex-none">
                            Próxima <span aria-hidden="true">→</span>
                        </button>
                    @else
                        <button type="button" wire:click="saveCurrent" class="inline-flex flex-1 items-center justify-center rounded-xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-500 sm:flex-none">
                            Concluir
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @else
        <p class="mt-8 rounded-xl border border-dashed border-heart-border bg-heart-card px-4 py-8 text-center text-heart-muted-foreground">Nenhuma pergunta cadastrada. Execute <code class="rounded bg-heart-muted px-1 py-0.5 text-xs">php artisan db:seed --class=PerguntaSeeder</code>.</p>
    @endif
</div>
