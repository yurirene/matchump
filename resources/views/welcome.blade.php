<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal de Acesso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            
            color: white;
            font-size: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        }

        
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                rgba(0, 0, 0, 0.8), 
                rgba(0, 0, 0, 0.8)
            ), url('/assets/img/bg-sicom.jpg') no-repeat center center;
            background-size: cover;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="d-flex align-items-center justify-content-center vh-100">
        <div class="text-center">
            <h1 class="display-4 fw-bold mb-5">Bem-vindo(a)</h1>
            <p class="lead mb-4">Selecione seu tipo de acesso para continuar.</p>
            <div class="d-grid gap-3 col-md-8 mx-auto">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg py-3 shadow">
                    <i class="bi bi-person-badge"></i> Acesso da Diretoria
                </a>
                <a href="{{ route('login.delegados') }}" class="btn btn-secondary btn-lg py-3 shadow">
                    <i class="bi bi-person-badge"></i> Acesso de Delegados
                </a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>