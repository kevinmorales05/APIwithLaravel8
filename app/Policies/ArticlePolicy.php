<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;
    //se ejecuta antes de cualquier verificacion
    public function before($user, $ability)
    {
        if ($user->isGranted(User::ROLE_SUPERADMIN)) {
            return true;
        }
    }
    //para ver un articulo se requiere roll user
    public function viewAny(User $user)
    {
        //con true todos los usuarios pueden ver
        return true;// $user->isGranted(User::ROLE_USER);
    }
    //ver un articulo especifico
    public function view(User $user, Article $article)
    {
        return $user->isGranted(User::ROLE_USER);
    }
    
    public function create(User $user)
    {
        return $user->isGranted(User::ROLE_USER);
    }
    //si esta dentro del middleware no es necesario verificar
    public function update(User $user, Article $article)
    {
        return $user->isGranted(User::ROLE_USER) && $user->id === $article->user_id;
    }
    public function delete(User $user, Article $article)
    {
        return $user->isGranted(User::ROLE_ADMIN);
    }

}
