<?php

namespace App\Policies;

use App\Models\User;

class ActorPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        return $user->role->name == 'admin';
    }
}
