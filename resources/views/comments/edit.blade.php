@extends('layouts.app')

@section('title', 'Редактировать комментарий')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="mb-3">
                    <a href="{{ route('articles.show', $comment->article_id) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Вернуться к статье
                    </a>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Редактировать комментарий</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="author" class="form-label">Ваше имя</label>
                                <input
                                    type="text"
                                    class="form-control @error('author') is-invalid @enderror"
                                    id="author"
                                    name="author"
                                    value="{{ old('author', $comment->author) }}"
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
                                    rows="5"
                                    required
                                >{{ old('content', $comment->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Сохранить изменения
                                </button>
                                <a href="{{ route('articles.show', $comment->article_id) }}" class="btn btn-outline-secondary">
                                    Отмена
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
