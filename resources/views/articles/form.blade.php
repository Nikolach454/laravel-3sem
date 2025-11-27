@extends('layouts.app')

@section('title', $article ? 'Редактировать статью' : 'Создать статью')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">{{ $article ? 'Редактировать статью' : 'Создать новую статью' }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ $article ? route('articles.update', $article->id) : route('articles.store') }}" method="POST">
                            @csrf
                            @if($article)
                                @method('PUT')
                            @endif

                            <div class="mb-3">
                                <label for="title" class="form-label">Заголовок</label>
                                <input
                                    type="text"
                                    class="form-control @error('title') is-invalid @enderror"
                                    id="title"
                                    name="title"
                                    value="{{ old('title', $article->title ?? '') }}"
                                    required
                                >
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @if(!$article)
                                <div class="alert alert-info">
                                    <strong>Автор:</strong> {{ auth()->user()->name }}
                                </div>
                            @else
                                <div class="mb-3">
                                    <label class="form-label">Автор</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        value="{{ $article->author }}"
                                        disabled
                                    >
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="published_at" class="form-label">Дата публикации</label>
                                <input
                                    type="datetime-local"
                                    class="form-control @error('published_at') is-invalid @enderror"
                                    id="published_at"
                                    name="published_at"
                                    value="{{ old('published_at', $article && $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}"
                                    required
                                >
                                @error('published_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Содержание</label>
                                <textarea
                                    class="form-control @error('content') is-invalid @enderror"
                                    id="content"
                                    name="content"
                                    rows="10"
                                    required
                                >{{ old('content', $article->content ?? '') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('articles.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Отмена
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> {{ $article ? 'Обновить' : 'Создать' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
