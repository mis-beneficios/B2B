<?php

namespace App\Policies;

use App\Estancia;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EstanciaPolicy
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
        $roles = array('admin');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Estancia  $estancia
     * @return mixed
     */
    public function view(User $user, Estancia $estancia)
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
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Estancia  $estancia
     * @return mixed
     */
    public function update(User $user)
    {
        $roles = array('admin');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Estancia  $estancia
     * @return mixed
     */
    public function delete(User $user, Estancia $estancia)
    {
        $roles = array('admin');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Estancia  $estancia
     * @return mixed
     */
    public function restore(User $user, Estancia $estancia)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Estancia  $estancia
     * @return mixed
     */
    public function forceDelete(User $user, Estancia $estancia)
    {
        //
    }
}
