<?php

namespace App\Policies;

use App\Models\Topics;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TopicPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function update(User $user, Topics $topic)
    {
        return $user->id === $topic->user_id;
    }

    public function destroy(User $user, Topics $topic)
    {
        return $user->id === $topic->user_id;
    }
}
