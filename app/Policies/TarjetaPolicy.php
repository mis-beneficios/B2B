<?php

namespace App\Policies;

use App\Tarjeta;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TarjetaPolicy
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
        $roles = array('admin', 'collector');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Tarjeta  $tarjeta
     * @return mixed
     */
    public function view(User $user, Tarjeta $tarjeta)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $roles = array('admin', 'collector', 'control', 'quality', 'sales', 'supervisor');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Tarjeta  $tarjeta
     * @return mixed
     */
    public function update(User $user, Tarjeta $tarjeta)
    {
        $roles = array('admin', 'collector');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Tarjeta  $tarjeta
     * @return mixed
     */
    public function delete(User $user, Tarjeta $tarjeta)
    {
        $roles = array('admin', 'collector');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Tarjeta  $tarjeta
     * @return mixed
     */
    public function restore(User $user, Tarjeta $tarjeta)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Tarjeta  $tarjeta
     * @return mixed
     */
    public function forceDelete(User $user, Tarjeta $tarjeta)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Tarjeta  $tarjeta
     * @return mixed
     */
    public function show_cards(User $user)
    {
        $roles = array('admin', 'collector');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

}
