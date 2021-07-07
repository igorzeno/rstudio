<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Article;
use Illuminate\Auth\Access\HandlesAuthorization;

class DelarticlePolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Article $article){
        return $user->id === $article->user_id;
    }
}
