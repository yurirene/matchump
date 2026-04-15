<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Área do Delegado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            padding-bottom: 60px;
            /* espaço para o menu fixo inferior */
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        header {
            background-color: #fff;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .bottom-nav {
            background-color: #fff;
            border-top: 1px solid #ddd;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            z-index: 1040;
        }

        .bottom-nav a {
            color: #6c757d;
            font-size: 12px;
            text-align: center;
            text-decoration: none;
        }

        .bottom-nav a.active {
            color: rgb(187, 169, 12);
            /* cor destaque (como vermelho do iFood) */
        }

        .bottom-nav i {
            font-size: 20px;
            display: block;
        }

        .content {
            padding: 1rem;
        }
    </style>
    @stack('styles')
</head>

<body>

    <!-- Header -->
    <header class="text-center">
        <h5 class="mb-0">
            <a href="#"><img src="/assets/svg/logo_colorida.svg" alt="Logo" class="w-100" style="height: 40px;"></a>
        </h5>
    </header>

    <!-- Conteúdo principal -->
    <main class="content">
        {{ $slot }}
    </main>

    <!-- Menu inferior fixo -->
    @auth('delegados')
    <nav class="bottom-nav">
        <a href="{{ route('area-delegado.home') }}" class="{{ request()->routeIs('area-delegado.home') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i>
            Início
        </a>
        <a href="{{ route('area-delegado.documentos') }}" class="{{ request()->routeIs('area-delegado.documentos') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i>
            Docs
        </a>
        <a href="{{ route('area-delegado.comissoes') }}" class="{{ request()->routeIs('area-delegado.comissoes') ? 'active' : '' }}">
            <i class="bi bi-people"></i>
            Comissões
        </a>
        <a href="{{ route('area-delegado.atas') }}" class="{{ request()->routeIs('area-delegado.atas') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-font"></i>
            Atas
        </a>
        
        <a href="#" class="{{ request()->routeIs('area-delegado.eleicao') ? 'active' : '' }}">
            <i class="bi bi-person-check"></i>
            Eleição
        </a>

    </nav>
    @endauth
    <!-- Scripts Bootstrap -->
    <script src="/assets/js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/jquery.mask.js"></script>
    <script>
        $(document).ready(function() {
            $('#codigo_reuniao').mask('AAAAA');
            $('.cpf').mask('000.000.000-00');
        });
    </script>
    @stack('scripts')
</body>

</html>