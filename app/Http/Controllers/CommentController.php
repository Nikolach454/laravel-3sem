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
        $validated['is_approved'] = false;

        $article->comments()->create($validated);

        return redirect()->route('articles.show', $article->id)->with('success', 'Комментарий успешно добавлен и ожидает модерации!');
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

    public function moderation()
    {
        if (!auth()->user()->hasRole('moderator')) {
            abort(403, 'Доступ запрещён.');
        }

        $comments = Comment::where('is_approved', false)
            ->with(['article', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('comments.moderation', ['comments' => $comments]);
    }

    public function approve(Comment $comment)
    {
        if (!auth()->user()->hasRole('moderator')) {
            abort(403, 'Доступ запрещён.');
        }

        $comment->update(['is_approved' => true]);

        return redirect()->route('comments.moderation')->with('success', 'Комментарий одобрен!');
    }

    public function reject(Comment $comment)
    {
        if (!auth()->user()->hasRole('moderator')) {
            abort(403, 'Доступ запрещён.');
        }

        $comment->delete();

        return redirect()->route('comments.moderation')->with('success', 'Комментарий отклонён и удалён!');
    }
}
