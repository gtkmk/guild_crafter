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
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Meu Projeto</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegação">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contato</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container text-center my-4">
        @yield('content')
    </div>

    <footer class="footer bg-dark text-center text-white py-1">
        <div class="container">
            <span class="small">© 2024 Guild Crafter</span>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2JDzN1SQZog+KN2cP0rHd3ZZlNWKU8l1xT/w1L1sYuNS2EloOfktpZf0YBd" crossorigin="anonymous"></script>
</body>
</html>
