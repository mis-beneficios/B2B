<?php

namespace App\Policies;

use App\Actividades;
use App\Concal;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActividadesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
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
     * @param  \App\Actividades  $actividades
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Actividades $actividades)
    {

    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Concal $concal)
    {
        dd($concal);
        $roles = array('admin', 'conveniant');
        if (in_array($user->role, $roles)) {
            return true;
        }

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Actividades  $actividades
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Actividades $actividades)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Actividades  $actividades
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Actividades $actividades)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Actividades  $actividades
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Actividades $actividades)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Actividades  $actividades
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Actividades $actividades)
    {
        //
    }
}
