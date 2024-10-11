<?php

namespace App\Policies;

use App\Comision;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ComisionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {

        $roles = array('admin', 'collector', 'control', 'conveniant', 'quality', 'recepcionist', 'reserver', 'sales', 'supervisor');
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
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
    public function view(User $user, Comision $comision)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $roles = array('admin', 'control', 'supervisor');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Comision  $comision
     * @return mixed
     */
    public function update(User $user, Comision $comision)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Comision  $comision
     * @return mixed
     */
    public function delete(User $user, Comision $comision)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Comision  $comision
     * @return mixed
     */
    public function restore(User $user, Comision $comision)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Comision  $comision
     * @return mixed
     */
    public function forceDelete(User $user, Comision $comision)
    {
        //
    }

}
