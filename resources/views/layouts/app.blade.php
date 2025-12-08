<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Мой сайт')</title>

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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="notification-app"></div>
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
                            <a class="nav-link {{ request()->routeIs('articles.*') ? 'active' : '' }}" href="{{ route('articles.index') }}">Новости</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">О нас</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('contacts') ? 'active' : '' }}" href="{{ route('contacts') }}">Контакты</a>
                        </li>

                        @auth
                            @if(Auth::user()->hasRole('moderator'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('comments.moderation') ? 'active' : '' }}" href="{{ route('comments.moderation') }}">Модерация</a>
                            </li>
                            @endif
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Уведомления
                                    @if(Auth::user()->unreadNotifications->count() > 0)
                                        <span class="badge bg-danger">{{ Auth::user()->unreadNotifications->count() }}</span>
                                    @endif
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown" style="min-width: 300px; max-height: 400px; overflow-y: auto;">
                                    @forelse(Auth::user()->unreadNotifications as $notification)
                                        <li>
                                            <a class="dropdown-item" href="{{ route('notifications.read', $notification->id) }}">
                                                <strong>{{ $notification->data['article_title'] }}</strong><br>
                                                <small class="text-muted">{{ $notification->data['message'] }}</small><br>
                                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                            </a>
                                        </li>
                                        @if(!$loop->last)
                                            <li><hr class="dropdown-divider"></li>
                                        @endif
                                    @empty
                                        <li><span class="dropdown-item text-muted">Нет новых уведомлений</span></li>
                                    @endforelse
                                </ul>
                            </li>
                            <li class="nav-item">
                                <span class="nav-link">Привет, {{ Auth::user()->name }}</span>
                            </li>
                            <li class="nav-item">
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-link nav-link" style="display: inline; border: none; background: none;">Выход</button>
                                </form>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Вход</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">Регистрация</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
    </header>


    <main class="py-5">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
</body>
</html>
