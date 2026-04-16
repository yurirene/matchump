<!DOCTYPE html>
<html lang="pt-BR" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'MatchUMP' }} — MatchUMP</title>
    @if (file_exists(public_path('css/match.css')))
        <link rel="stylesheet" href="{{ asset('css/match.css') }}?v={{ (int) filemtime(public_path('css/match.css')) }}">
    @else
        @include('layouts.partials.heart-tailwind-cdn')
    @endif
    @livewireStyles
</head>

<body class="flex min-h-full flex-col bg-gradient-to-br from-heart-primary/[0.06] via-heart-background to-heart-accent font-sans text-heart-foreground antialiased">
    <header class="sticky top-0 z-50 w-full border-b border-heart-border/80 bg-heart-background/90 backdrop-blur-md supports-[backdrop-filter]:bg-heart-background/75">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
            <a href="{{ auth('match')->check() ? route('match.dashboard') : route('login') }}" class="flex items-center gap-2 text-xl font-semibold text-heart-foreground">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-heart-primary text-heart-primary-foreground shadow-sm">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                    </svg>
                </span>
                <span>MatchUMP</span>
            </a>

            @auth('match')
                <nav class="flex flex-wrap items-center justify-end gap-1 sm:gap-5">
                    <a href="{{ route('match.dashboard') }}" class="text-sm font-medium transition-colors {{ request()->routeIs('match.dashboard') ? 'text-heart-primary' : 'text-heart-foreground/60 hover:text-heart-primary' }}">
                        Início
                    </a>
                    <a href="{{ route('match.perfil') }}" class="text-sm font-medium transition-colors {{ request()->routeIs('match.perfil') ? 'text-heart-primary' : 'text-heart-foreground/60 hover:text-heart-primary' }}">
                        Perfil
                    </a>
                    <a href="{{ route('match.matches') }}" class="text-sm font-medium transition-colors {{ request()->routeIs('match.matches') || request()->routeIs('match.detalhe') ? 'text-heart-primary' : 'text-heart-foreground/60 hover:text-heart-primary' }}">
                        Matches
                    </a>
                    <a href="{{ route('match.questionario') }}" class="text-sm font-medium transition-colors {{ request()->routeIs('match.questionario') ? 'text-heart-primary' : 'text-heart-foreground/60 hover:text-heart-primary' }}">
                        Questionário
                    </a>
                    <a href="{{ route('match.discovery') }}" class="text-sm font-medium transition-colors {{ request()->routeIs('match.discovery') ? 'text-heart-primary' : 'text-heart-foreground/60 hover:text-heart-primary' }}">
                        Descoberta
                    </a>
                    <span class="hidden text-heart-border sm:inline">|</span>
                    <span class="hidden max-w-[10rem] truncate text-sm text-heart-muted-foreground sm:inline" title="{{ auth('match')->user()->name }}">{{ auth('match')->user()->name }}</span>
                    <form method="POST" action="{{ route('match.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="rounded-lg border border-heart-border bg-white px-3 py-1.5 text-sm font-medium text-heart-foreground/80 shadow-sm transition hover:bg-heart-muted">
                            Sair
                        </button>
                    </form>
                </nav>
            @else
                <nav class="flex items-center gap-3 text-sm">
                    <a href="{{ route('login') }}" class="font-medium text-heart-foreground/70 hover:text-heart-primary">Entrar</a>
                    <a href="{{ route('register') }}" class="rounded-lg bg-heart-primary px-4 py-2 font-medium text-heart-primary-foreground shadow-sm hover:opacity-95">Cadastrar</a>
                </nav>
            @endauth
        </div>
    </header>

    <main class="mx-auto w-full max-w-7xl flex-1 px-4 py-8 sm:px-6 lg:px-8">
        {{ $slot }}
    </main>

    @livewireScripts
</body>

</html>
