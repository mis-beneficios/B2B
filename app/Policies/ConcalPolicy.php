<?php

namespace App\Policies;

use App\Concal;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConcalPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        $roles = array('conveniant', 'admin');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Concal  $concal
     * @return mixed
     */
    public function view(User $user, Concal $concal)
    {
        if ($user->role == 'admin') {
            return true;
        } elseif ($user->role == 'conveniant' && $concal->user_id == $user->id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Concal  $concal
     * @return mixed
     */
    public function update(User $user, Concal $concal)
    {
        if ($user->role == 'admin') {
            return true;
        } elseif ($user->role == 'conveniant' && $concal->user_id == $user->id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Concal  $concal
     * @return mixed
     */
    public function delete(User $user, Concal $concal)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Concal  $concal
     * @return mixed
     */
    public function restore(User $user, Concal $concal)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Concal  $concal
     * @return mixed
     */
    public function forceDelete(User $user, Concal $concal)
    {
        //
    }

    public function reasignar(User $user, Concal $concal)
    {
        $roles = array('admin', 'conveniant');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;

    }

    public function convenio(User $user, Concal $concal)
    {
        $roles = array('admin', 'conveniant');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }
}
