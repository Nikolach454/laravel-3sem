<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Article $article): bool
    {
        return true;
    }

    public function create(User $user): Response
    {
        return $user->hasRole('moderator')
            ? Response::allow()
            : Response::deny('Только модераторы могут создавать статьи.');
    }

    public function update(User $user, Article $article): Response
    {
        return $user->hasRole('moderator')
            ? Response::allow()
            : Response::deny('Только модераторы могут редактировать статьи.');
    }

    public function delete(User $user, Article $article): Response
    {
        return $user->hasRole('moderator')
            ? Response::allow()
            : Response::deny('Только модераторы могут удалять статьи.');
    }
}
