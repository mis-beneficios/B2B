<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Salesgroup as SG;
use App\User;

class Salesgroup
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
     * @param  \App\Salesgroup  $salesgroup
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Salesgroup $salesgroup)
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
     * @param  \App\Salesgroup  $salesgroup
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Salesgroup $salesgroup)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Salesgroup  $salesgroup
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Salesgroup $salesgroup)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Salesgroup  $salesgroup
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Salesgroup $salesgroup)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Salesgroup  $salesgroup
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Salesgroup $salesgroup)
    {
        //
    }
}
