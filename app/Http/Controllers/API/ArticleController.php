<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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

        return response()->json([
            'success' => true,
            'articles' => $articles
        ], 200);
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

        return response()->json([
            'success' => true,
            'message' => 'Статья успешно создана!',
            'article' => $article
        ], 201);
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

        return response()->json([
            'success' => true,
            'data' => $articleData
        ], 200);
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $this->authorize('update', $article);

        $article->update($request->validated());

        DB::table('cache')->delete();

        return response()->json([
            'success' => true,
            'message' => 'Статья успешно обновлена!',
            'article' => $article
        ], 200);
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        $article->delete();

        DB::table('cache')->delete();

        return response()->json([
            'success' => true,
            'message' => 'Статья успешно удалена!'
        ], 200);
    }
}
