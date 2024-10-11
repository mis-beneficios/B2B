<?php

namespace App\Policies;

use App\Convenio;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConveniosPolicy
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
        $roles = array('admin', 'conveniant', 'sales', 'supervisor');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Convenio  $convenio
     * @return mixed
     */
    public function view(User $user, Convenio $convenio)
    {

        $roles = array('admin', 'conveniant');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
        // if ($user->role == 'admin') {
        //     return true;
        // } elseif ($user->role == 'conveniant' && $convenio->user_id == $user->id) {
        //     return true;
        // }
        // return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $roles = array('admin', 'conveniant');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Convenio  $convenio
     * @return mixed
     */
    public function update(User $user, Convenio $convenio)
    {
        if ($user->role == 'admin') {
            return true;
        } elseif ($user->role == 'conveniant' && $convenio->user_id == $user->id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Convenio  $convenio
     * @return mixed
     */
    public function delete(User $user, Convenio $convenio)
    {
        $roles = array('admin');
        if (in_array($user->role, $roles)) {

            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Convenio  $convenio
     * @return mixed
     */
    public function restore(User $user, Convenio $convenio)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Convenio  $convenio
     * @return mixed
     */
    public function forceDelete(User $user, Convenio $convenio)
    {
        //
    }

    /**
     * Determina si el usuario logueado puede reasignar el convenio a otro usuario.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function reasignar(User $user)
    {
        $roles = array('admin');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }
}
