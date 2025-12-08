<?php

namespace App\Http\Controllers;

use App\Events\NewArticleEvent;
use App\Jobs\VeryLongJob;
use App\Models\Article;
use App\Models\User;
use App\Notifications\NewArticleNotification;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function index()
    {
        $page = request()->get('page', 1);
        $cacheKey = "articles_page_{$page}";

        $articles = Cache::remember($cacheKey, 3600, function () {
            return Article::orderBy('published_at', 'desc')->paginate(6);
        });

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

        VeryLongJob::dispatch($article);

        event(new NewArticleEvent($article));

        $readers = User::whereDoesntHave('roles', function ($query) {
            $query->whereIn('name', ['moderator', 'admin']);
        })->get();

        Notification::send($readers, new NewArticleNotification($article));

        $totalPages = Article::count() / 6 + 1;
        for ($i = 1; $i <= $totalPages; $i++) {
            Cache::forget("articles_page_{$i}");
        }

        return redirect()->route('articles.index')->with('success', 'Статья успешно создана!');
    }

    public function show(Article $article)
    {
        $cacheKey = "article_{$article->id}_with_comments";

        $articleData = Cache::rememberForever($cacheKey, function () use ($article) {
            return [
                'article' => $article,
                'comments' => $article->comments()->with('user')->get(),
            ];
        });

        return view('articles.show', $articleData);
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

        DB::table('cache')->delete();

        return redirect()->route('articles.index')->with('success', 'Статья успешно обновлена!');
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        $article->delete();

        DB::table('cache')->delete();

        return redirect()->route('articles.index')->with('success', 'Статья успешно удалена!');
    }
}
