@extends('layouts.app')

@section('title', 'Главная страница')

@section('content')
    <div class="container">
        <h1 class="mb-4">Список статей</h1>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Превью</th>
                        <th>Название</th>
                        <th>Дата</th>
                        <th>Краткое описание</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articles as $index => $article)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <a href="{{ route('gallery', $index) }}">
                                    <img src="{{ asset($article['preview_image']) }}"
                                         alt="{{ $article['name'] }}"
                                         class="img-thumbnail"
                                         style="max-width: 100px; cursor: pointer;">
                                </a>
                            </td>
                            <td>{{ $article['name'] }}</td>
                            <td>{{ $article['date'] }}</td>
                            <td>{{ $article['shortDesc'] ?? substr($article['desc'], 0, 100) . '...' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
