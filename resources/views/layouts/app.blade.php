<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Guild Crafter')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

    <style>
        html, body {
            height: 100%;
        }
        body {
            background-color: #121212;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            padding-top: 60px;
            justify-content: top;
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
        .content {
            min-height: 100%;
            padding-bottom: 60px;
        }
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
        }
        svg {
            width: 2rem;
            height: 2rem;
        }
        .relative.z-0.inline-flex.rtl\:flex-row-reverse.shadow-sm.rounded-md {
            padding-bottom: 50px;
        }

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/" style="font-size: 18px; margin-left: 20px;">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('players.index') }}" style="font-size: 18px; margin-left: 20px;">Gerenciar Jogadores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('rpg-sessions.index') }}" style="font-size: 18px; margin-right: 120px !important;">Gerenciar Sessões de RPG</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container text-center my-4">
        @if (session()->has('success'))
            <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sucesso!</strong> {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div id="error-alert" class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="footer bg-dark text-center text-white py-1 mt-auto">
        <div class="container">
            <span class="small">© 2024 Guild Crafter</span>
        </div>
    </footer>

    @yield('scripts')

    <script>
        setTimeout(() => {
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                successAlert.classList.remove('show');
                successAlert.classList.add('fade');
                setTimeout(() => successAlert.remove(), 150);
            }

            const errorAlert = document.getElementById('error-alert');
            if (errorAlert) {
                errorAlert.classList.remove('show');
                errorAlert.classList.add('fade');
                setTimeout(() => errorAlert.remove(), 150);
            }
        }, 3200);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2JDzN1SQZog+KN2cP0rHd3ZZlNWKU8l1xT/w1L1sYuNS2EloOfktpZf0YBd" crossorigin="anonymous"></script>
</body>
</html>
