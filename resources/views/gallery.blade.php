@extends('layouts.app')

@section('title', $article['name'])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $article['name'] }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h2 class="mb-0">{{ $article['name'] }}</h2>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted">
                                <i class="bi bi-calendar"></i> Дата публикации: {{ $article['date'] }}
                            </small>
                        </div>

                        <div class="text-center mb-4">
                            <img src="{{ asset($article['full_image']) }}"
                                 alt="{{ $article['name'] }}"
                                 class="img-fluid rounded shadow"
                                 style="max-width: 100%; height: auto;">
                        </div>

                        <div class="article-content">
                            <p class="lead">{{ $article['desc'] }}</p>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('home') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Вернуться к списку
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .article-content {
            font-size: 1.1rem;
            line-height: 1.8;
            text-align: justify;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection
