<?php

namespace App\Http\Controllers;

use App\Mail\NewArticleNotification;
use App\Models\Article;
use App\Models\Role;
use App\Models\User;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::orderBy('published_at', 'desc')->paginate(6);

        return view('articles.index', ['articles' => $articles]);
    }

    public function create()
    {
        $this->authorize('create', Article::class);

        return view('articles.form', ['article' => null]);
    }

    public function store(ArticleRequest $request)
    {
        $this->authorize('create', Article::class);

        $validated = $request->validated();
        $validated['user_id'] = auth()->id();
        $validated['author'] = auth()->user()->name;

        $article = Article::create($validated);

        $moderatorRole = Role::where('name', 'moderator')->first();
        if ($moderatorRole) {
            $moderators = $moderatorRole->users;
            foreach ($moderators as $moderator) {
                try {
                    Mail::to($moderator->email)->send(new NewArticleNotification($article));
                } catch (\Exception $e) {
                    \Log::error('Email sending failed: ' . $e->getMessage());
                }
            }
        }

        return redirect()->route('articles.index')->with('success', 'Статья успешно создана!');
    }

    public function show(Article $article)
    {
        return view('articles.show', ['article' => $article]);
    }

    public function edit(Article $article)
    {
        $this->authorize('update', $article);

        return view('articles.form', ['article' => $article]);
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $this->authorize('update', $article);

        $article->update($request->validated());

        return redirect()->route('articles.index')->with('success', 'Статья успешно обновлена!');
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Статья успешно удалена!');
    }
}
