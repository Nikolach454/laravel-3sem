@extends('layouts.app')

@section('title', 'Модерация комментариев')

@section('content')
<div class="container">
    <h1 class="mb-4">Модерация комментариев</h1>

    @if($comments->isEmpty())
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> Нет комментариев, ожидающих модерации.
        </div>
    @else
        <p class="text-muted">Всего комментариев на модерации: {{ $comments->count() }}</p>

        <div class="row">
            @foreach($comments as $comment)
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header bg-warning bg-opacity-25">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $comment->author }}</strong>
                                    <span class="text-muted">• {{ $comment->created_at->format('d.m.Y H:i') }}</span>
                                </div>
                                <span class="badge bg-warning text-dark">Ожидает модерации</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $comment->content }}</p>

                            <div class="mt-3">
                                <h6 class="text-muted">Статья:</h6>
                                <a href="{{ route('articles.show', $comment->article_id) }}" class="text-decoration-none">
                                    {{ $comment->article->title }}
                                </a>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex gap-2">
                                <form action="{{ route('comments.approve', $comment->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-check-circle"></i> Одобрить
                                    </button>
                                </form>

                                <form action="{{ route('comments.reject', $comment->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Вы уверены, что хотите отклонить этот комментарий?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-x-circle"></i> Отклонить
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
@endsection
@endsection
