<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Incidencia;
use App\User;

class IncidenciaPolicy
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
     * @param  \App\Incidencia  $incidencia
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Incidencia $incidencia)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Incidencia  $incidencia
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Incidencia $incidencia)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Incidencia  $incidencia
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Incidencia $incidencia)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Incidencia  $incidencia
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Incidencia $incidencia)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Incidencia  $incidencia
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Incidencia $incidencia)
    {
        //
    }
}
