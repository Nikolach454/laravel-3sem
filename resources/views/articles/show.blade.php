@extends('layouts.app')

@section('title', $article->title)

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="mb-3">
                    <a href="{{ route('articles.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Вернуться к списку
                    </a>
                </div>

                <article class="card">
                    <div class="card-body">
                        <h1 class="card-title mb-3">{{ $article->title }}</h1>

                        <div class="text-muted mb-4">
                            <span class="me-3">
                                <i class="bi bi-person"></i> {{ $article->author }}
                            </span>
                            <span>
                                <i class="bi bi-calendar"></i> {{ $article->published_at->format('d.m.Y H:i') }}
                            </span>
                        </div>

                        <div class="article-content mb-4">
                            {!! nl2br(e($article->content)) !!}
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                Создано: {{ $article->created_at->format('d.m.Y H:i') }}
                                @if($article->updated_at != $article->created_at)
                                    | Обновлено: {{ $article->updated_at->format('d.m.Y H:i') }}
                                @endif
                            </small>

                            <div>
                                @can('update', $article)
                                    <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-warning">
                                        <i class="bi bi-pencil"></i> Редактировать
                                    </a>
                                @endcan
                                @can('delete', $article)
                                    <form action="{{ route('articles.destroy', $article->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Вы уверены, что хотите удалить эту статью?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-trash"></i> Удалить
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Comments Section -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="mb-0">Комментарии ({{ $article->comments()->where('is_approved', true)->count() }})</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Add Comment Form -->
                        <form action="{{ route('comments.store', $article->id) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="mb-3">
                                <label for="author" class="form-label">Ваше имя</label>
                                <input
                                    type="text"
                                    class="form-control @error('author') is-invalid @enderror"
                                    id="author"
                                    name="author"
                                    value="{{ old('author') }}"
                                    required
                                >
                                @error('author')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Комментарий</label>
                                <textarea
                                    class="form-control @error('content') is-invalid @enderror"
                                    id="content"
                                    name="content"
                                    rows="3"
                                    required
                                >{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-chat-left-text"></i> Добавить комментарий
                            </button>
                        </form>

                        <hr>

                        <!-- Comments List -->
                        @forelse($article->comments()->where('is_approved', true)->latest()->get() as $comment)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="card-subtitle mb-2">
                                                <i class="bi bi-person-circle"></i> {{ $comment->author }}
                                            </h6>
                                            <p class="card-text">{{ $comment->content }}</p>
                                            <small class="text-muted">
                                                <i class="bi bi-clock"></i> {{ $comment->created_at->format('d.m.Y H:i') }}
                                            </small>
                                        </div>
                                        <div class="ms-2">
                                            @can('update', $comment)
                                                <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-sm btn-outline-warning me-1">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            @endcan
                                            @can('delete', $comment)
                                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Вы уверены, что хотите удалить этот комментарий?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted text-center">Пока нет комментариев. Будьте первым!</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
