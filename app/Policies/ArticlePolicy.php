<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;
    public function before($user, $ability)
    {
        if ($user->isGranted(User::ROLE_SUPERADMIN)) {
            return true;
        }
    }
    
    public function viewAny(User $user)
    {
        return $user->isGranted(User::ROLE_USER);
    }
    
    public function view(User $user, Article $article)
    {
        return $user->isGranted(User::ROLE_USER);
    }
    
    public function create(User $user)
    {
        return $user->isGranted(User::ROLE_USER);
    }
    
    public function update(User $user, Article $article)
    {
        return $user->isGranted(User::ROLE_USER) && $user->id === $article->user_id;
    }
    public function delete(User $user, Article $article)
    {
        return $user->isGranted(User::ROLE_ADMIN);
    }

}
