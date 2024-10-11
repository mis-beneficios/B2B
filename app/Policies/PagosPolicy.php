<?php

namespace App\Policies;

use App\Pago;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagosPolicy
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
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Pago  $pago
     * @return mixed
     */
    public function view(User $user, Pago $pago)
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
     * @param  \App\Pago  $pago
     * @return mixed
     */
    public function update(User $user, Pago $pago)
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
     * @param  \App\Pago  $pago
     * @return mixed
     */
    public function delete(User $user, Pago $pago)
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
     * @param  \App\Pago  $pago
     * @return mixed
     */
    public function restore(User $user, Pago $pago)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Pago  $pago
     * @return mixed
     */
    public function forceDelete(User $user, Pago $pago)
    {
        //
    }
}
