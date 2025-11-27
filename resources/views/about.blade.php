@extends('layouts.app')

@section('title', 'О нас')

@section('content')
<div class="row">
    <div class="col-12">

        <div class="mb-4">
            <h1 class="display-5 fw-bold">О нас</h1>
            <hr class="my-4">
        </div>


        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h2 class="card-title h4 mb-3">Наша история</h2>
                        <p class="card-text">
                            Мы — команда разработчиков, изучающих современные веб-технологии. Наш проект создан в рамках учебной программы по изучению Laravel Framework — одного из самых популярных PHP-фреймворков в мире.
                        </p>
                        <p class="card-text">
                            Laravel предоставляет элегантный синтаксис и мощные инструменты для создания веб-приложений любой сложности. В процессе обучения мы осваиваем ключевые концепции: маршрутизацию, шаблонизацию, работу с базами данных и многое другое.
                        </p>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h2 class="card-title h4 mb-3">Наши цели</h2>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Изучение Laravel:</strong> Освоение фреймворка и его возможностей
                            </li>
                            <li class="list-group-item">
                                <strong>Blade шаблонизатор:</strong> Создание переиспользуемых компонентов интерфейса
                            </li>
                            <li class="list-group-item">
                                <strong>Маршрутизация:</strong> Организация структуры веб-приложения
                            </li>
                            <li class="list-group-item">
                                <strong>Bootstrap 5:</strong> Разработка адаптивного и современного дизайна
                            </li>
                            <li class="list-group-item">
                                <strong>Best Practices:</strong> Применение лучших практик веб-разработки
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title h4 mb-3">Технологический стек</h2>
                        <p class="card-text">В разработке этого проекта используются следующие технологии:</p>
                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-danger me-2">Backend</span>
                                    <span>Laravel 10.x</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-primary me-2">Frontend</span>
                                    <span>Bootstrap 5.3</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-success me-2">Template</span>
                                    <span>Blade Engine</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-warning text-dark me-2">Language</span>
                                    <span>PHP 8.x</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Быстрые ссылки</h5>
                        <div class="list-group list-group-flush">
                            <a href="{{ route('home') }}" class="list-group-item list-group-item-action">
                                Главная страница
                            </a>
                            <a href="{{ route('contacts') }}" class="list-group-item list-group-item-action">
                                Наши контакты
                            </a>
                            <a href="https://laravel.com" target="_blank" class="list-group-item list-group-item-action">
                                Документация Laravel
                            </a>
                            <a href="https://getbootstrap.com" target="_blank" class="list-group-item list-group-item-action">
                                Bootstrap Docs
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm bg-light">
                    <div class="card-body">
                        <h5 class="card-title">Интересный факт</h5>
                        <p class="card-text small">
                            Laravel был создан Тейлором Отвеллом в 2011 году и с тех пор стал одним из самых популярных PHP-фреймворков в мире. Его название происходит от типа архитектуры — "Narnia's Cair Paravel".
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
