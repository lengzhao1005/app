<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class BasePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if($user->can('manage_contents')){
            return true;
        }
    }
}
