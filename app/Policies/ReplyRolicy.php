<?php

namespace App\Policies;

use App\Models\Reply;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyRolicy
{
    use HandlesAuthorization;

    public function destory(User $current_user, Reply $reply)
    {
        return $current_user->isAuthOf($reply);
    }
}
