<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ArticleView;

class TrackArticleViews
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response->isSuccessful()) {
            $articleId = $request->route('article') ?? $request->route('id');

            ArticleView::create([
                'url' => $request->fullUrl(),
                'article_id' => is_object($articleId) ? $articleId->id : $articleId,
                'ip_address' => $request->ip(),
            ]);
        }

        return $response;
    }
}
