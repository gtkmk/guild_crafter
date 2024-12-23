<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Guild Crafter')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #121212;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        a {
            color: #0d6efd;
        }
        a:hover {
            color: #0056b3;
        }
        .container {
            max-width: 900px;
            width: 100%;
        }
        footer {
            width: 100%;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark w-100">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Meu Projeto</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('players.index') }}">Jogadores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('players.create') }}">Criar Jogador</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container text-center my-4">
        @yield('content')
    </div>

    <footer class="footer bg-dark text-center text-white py-3">
        <div class="container">
            <span>© {{ date('Y') }} Meu Projeto Laravel. Todos os direitos reservados.</span>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2JDzN1SQZog+KN2cP0rHd3ZZlNWKU8l1xT/w1L1sYuNS2EloOfktpZf0YBd" crossorigin="anonymous"></script>
</body>
</html>
