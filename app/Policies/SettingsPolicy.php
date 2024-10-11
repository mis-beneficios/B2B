<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingsPolicy
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

    public function options(User $user)
    {
        if ($user->username == 'dsanchez@pacifictravels.mx') {
            return true;
        }
        return false;
    }
}
