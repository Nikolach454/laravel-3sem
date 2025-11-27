@extends('layouts.app')

@section('title', 'Новости')

@section('content')
    <div class="container">
        <h1 class="mb-4">Новости</h1>

        @if($articles->count() > 0)
            <div class="row">
                @foreach($articles as $article)
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $article->title }}</h5>
                                <p class="card-text text-muted small">
                                    <i class="bi bi-person"></i> {{ $article->author }}
                                    <span class="ms-2">
                                        <i class="bi bi-calendar"></i> {{ $article->published_at->format('d.m.Y') }}
                                    </span>
                                </p>
                                <p class="card-text">{{ Str::limit($article->content, 200) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info">
                <h4 class="alert-heading">Новостей пока нет</h4>
                <p>Запустите миграции и сидеры командой:</p>
                <code>php artisan migrate --seed</code>
            </div>
        @endif
    </div>
@endsection
