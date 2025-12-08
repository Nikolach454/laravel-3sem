<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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

        $comment = $article->comments()->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Комментарий успешно добавлен и ожидает модерации!',
            'comment' => $comment
        ], 201);
    }

    public function update(CommentRequest $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Комментарий успешно обновлен!',
            'comment' => $comment
        ], 200);
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $articleId = $comment->article_id;
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Комментарий успешно удален!',
            'article_id' => $articleId
        ], 200);
    }

    public function moderation()
    {
        if (!auth()->user()->hasRole('moderator')) {
            return response()->json([
                'success' => false,
                'message' => 'Доступ запрещён.'
            ], 403);
        }

        $comments = Comment::where('is_approved', false)
            ->with(['article', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'comments' => $comments
        ], 200);
    }

    public function approve(Comment $comment)
    {
        if (!auth()->user()->hasRole('moderator')) {
            return response()->json([
                'success' => false,
                'message' => 'Доступ запрещён.'
            ], 403);
        }

        $comment->update(['is_approved' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Комментарий одобрен!',
            'comment' => $comment
        ], 200);
    }

    public function reject(Comment $comment)
    {
        if (!auth()->user()->hasRole('moderator')) {
            return response()->json([
                'success' => false,
                'message' => 'Доступ запрещён.'
            ], 403);
        }

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Комментарий отклонён и удалён!'
        ], 200);
    }
}
