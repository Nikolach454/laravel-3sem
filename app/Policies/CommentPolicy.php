<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Comment $comment): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Comment $comment): Response
    {
        if ($user->hasRole('moderator') || $comment->user_id === $user->id) {
            return Response::allow();
        }

        return Response::deny('Вы можете редактировать только свои комментарии.');
    }

    public function delete(User $user, Comment $comment): Response
    {
        if ($user->hasRole('moderator') || $comment->user_id === $user->id) {
            return Response::allow();
        }

        return Response::deny('Вы можете удалять только свои комментарии.');
    }
}
