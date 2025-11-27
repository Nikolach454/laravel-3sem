@extends('layouts.app')

@section('title', 'Новости')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Новости</h1>
            @auth
                <a href="{{ route('articles.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Добавить новость
                </a>
            @endauth
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($articles->count() > 0)
            <div class="row">
                @foreach($articles as $article)
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $article->title }}</h5>
                                <p class="card-text text-muted small">
                                    <i class="bi bi-person"></i> {{ $article->author }}
                                    <span class="ms-2">
                                        <i class="bi bi-calendar"></i> {{ $article->published_at->format('d.m.Y') }}
                                    </span>
                                </p>
                                <p class="card-text flex-grow-1">{{ Str::limit($article->content, 200) }}</p>
                                <div class="mt-3">
                                    <a href="{{ route('articles.show', $article->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Читать
                                    </a>
                                    @auth
                                        @if($article->user_id === auth()->id())
                                            <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-pencil"></i> Редактировать
                                            </a>
                                            <form action="{{ route('articles.destroy', $article->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Вы уверены, что хотите удалить эту статью?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash"></i> Удалить
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $articles->links() }}
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
