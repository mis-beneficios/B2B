<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;

class BancoPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    
    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Comision  $comision
     * @return mixed
     */
    public function view(User $user)
    {
        $roles = array('control', 'admin');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

}
