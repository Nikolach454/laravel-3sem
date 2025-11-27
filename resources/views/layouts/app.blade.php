<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Мой сайт')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
        footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            margin-top: auto;
        }
    </style>

    @yield('styles')
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">Мой сайт</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Главная</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('articles') ? 'active' : '' }}" href="{{ route('articles') }}">Новости</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">О нас</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('contacts') ? 'active' : '' }}" href="{{ route('contacts') }}">Контакты</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('signin') ? 'active' : '' }}" href="{{ route('signin') }}">Регистрация</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>


    <main class="py-5">
        <div class="container">
            @yield('content')
        </div>
    </main>


    <footer class="bg-light text-center">
        <div class="container">
            <p class="mb-0 text-muted">
                @yield('footer', 'Милосердов Николай Сергеевич, Группа 241-321')
            </p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
</body>
</html>
