<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::orderBy('published_at', 'desc')->paginate(6);

        return view('articles.index', ['articles' => $articles]);
    }

    public function create()
    {
        return view('articles.form', ['article' => null]);
    }

    public function store(ArticleRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();
        $validated['author'] = auth()->user()->name;

        Article::create($validated);

        return redirect()->route('articles.index')->with('success', 'Статья успешно создана!');
    }

    public function show(Article $article)
    {
        return view('articles.show', ['article' => $article]);
    }

    public function edit(Article $article)
    {
        // Проверяем, что пользователь может редактировать только свои статьи
        if ($article->user_id !== auth()->id()) {
            abort(403, 'У вас нет прав для редактирования этой статьи');
        }

        return view('articles.form', ['article' => $article]);
    }

    public function update(ArticleRequest $request, Article $article)
    {
        // Проверяем, что пользователь может редактировать только свои статьи
        if ($article->user_id !== auth()->id()) {
            abort(403, 'У вас нет прав для редактирования этой статьи');
        }

        $article->update($request->validated());

        return redirect()->route('articles.index')->with('success', 'Статья успешно обновлена!');
    }

    public function destroy(Article $article)
    {
        // Проверяем, что пользователь может удалять только свои статьи
        if ($article->user_id !== auth()->id()) {
            abort(403, 'У вас нет прав для удаления этой статьи');
        }

        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Статья успешно удалена!');
    }
}
