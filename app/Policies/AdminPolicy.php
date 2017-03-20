<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->hasRole('Administrator')) {
            return true;
        }
    }
}
