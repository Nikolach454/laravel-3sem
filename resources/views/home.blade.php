@extends('layouts.app')

@section('title', 'Главная страница')

@section('content')
<div class="row">
    <div class="col-12">

        <div class="bg-light p-5 rounded-3 mb-4">
            <div class="container-fluid py-5">
                <h1 class="display-4 fw-bold">Добро пожаловать!</h1>
                <p class="col-md-8 fs-4">
                    Рады приветствовать вас на нашем сайте. Здесь вы найдете интересную информацию о нашей компании и сможете связаться с нами.
                </p>
                <a href="{{ route('about') }}" class="btn btn-primary btn-lg">Узнать больше</a>
            </div>
        </div>


        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">О нашем проекте</h2>
                        <p class="card-text text-muted">
                            Это учебный проект, созданный для демонстрации работы с Laravel Framework, системой маршрутизации (Route) и шаблонизатором Blade.
                        </p>
                        <p class="card-text text-muted">
                            Проект включает в себя основные элементы веб-сайта: навигационное меню, несколько страниц с динамическим контентом и адаптивный дизайн на основе Bootstrap 5.
                        </p>
                    </div>
                </div>
            </div>
        </div>


        <div class="row mt-5">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-code-slash text-primary" viewBox="0 0 16 16">
                                <path d="M10.478 1.647a.5.5 0 1 0-.956-.294l-4 13a.5.5 0 0 0 .956.294l4-13zM4.854 4.146a.5.5 0 0 1 0 .708L1.707 8l3.147 3.146a.5.5 0 0 1-.708.708l-3.5-3.5a.5.5 0 0 1 0-.708l3.5-3.5a.5.5 0 0 1 .708 0zm6.292 0a.5.5 0 0 0 0 .708L14.293 8l-3.147 3.146a.5.5 0 0 0 .708.708l3.5-3.5a.5.5 0 0 0 0-.708l-3.5-3.5a.5.5 0 0 0-.708 0z"/>
                            </svg>
                        </div>
                        <h5 class="card-title">Laravel Framework</h5>
                        <p class="card-text text-muted">Мощный PHP-фреймворк для современной веб-разработки</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-file-earmark-text text-success" viewBox="0 0 16 16">
                                <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
                                <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                            </svg>
                        </div>
                        <h5 class="card-title">Blade Templates</h5>
                        <p class="card-text text-muted">Удобная система шаблонов для создания представлений</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-bootstrap text-danger" viewBox="0 0 16 16">
                                <path d="M5.062 12h3.475c1.804 0 2.888-.908 2.888-2.396 0-1.102-.761-1.916-1.904-2.034v-.1c.832-.14 1.482-.93 1.482-1.816 0-1.3-.955-2.11-2.542-2.11H5.062V12zm1.313-4.875V4.658h1.78c.973 0 1.542.457 1.542 1.237 0 .802-.604 1.23-1.764 1.23H6.375zm0 3.762V8.162h1.822c1.236 0 1.887.463 1.887 1.348 0 .896-.627 1.377-1.811 1.377H6.375z"/>
                                <path d="M0 4a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v8a4 4 0 0 1-4 4H4a4 4 0 0 1-4-4V4zm4-3a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V4a3 3 0 0 0-3-3H4z"/>
                            </svg>
                        </div>
                        <h5 class="card-title">Bootstrap 5</h5>
                        <p class="card-text text-muted">Адаптивный дизайн для всех устройств</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
