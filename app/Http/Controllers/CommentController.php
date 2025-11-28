<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Article;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Article $article)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        $article->comments()->create($validated);

        return redirect()->route('articles.show', $article->id)->with('success', 'Комментарий успешно добавлен!');
    }

    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);

        return view('comments.edit', ['comment' => $comment]);
    }

    public function update(CommentRequest $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->update($request->validated());

        return redirect()->route('articles.show', $comment->article_id)->with('success', 'Комментарий успешно обновлен!');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $articleId = $comment->article_id;
        $comment->delete();

        return redirect()->route('articles.show', $articleId)->with('success', 'Комментарий успешно удален!');
    }
}
