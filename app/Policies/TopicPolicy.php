<?php

namespace App\Policies;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TopicPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function update(User $user, Topic $topic)
    {
        return $user->isAuthOf($topic);
    }

    public function destroy(User $user, Topic $topic)
    {
        return $user->isAuthOf($topic);
    }
}
