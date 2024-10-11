<?php

namespace App\Observers;

use App\User;
use Auth;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        // dd($user->toArray(), $user->getChanges()->toArray());
        
        $auth = Auth::user();
        $old_log = $user->log;
        $log = "\n \n#**" . $auth->fullName . "**, [" . $auth->username . "]: \n";
        $log .= "### Fecha: **" . date('Y-m-d H:i:s') . "** \n";
        // foreach ($user->getChanges() as $key => $value) {
        //     $log .= "## **" . $key . "**: \n";
        //     $log .= "+ **" . $user[$key] . "** \n";
        //     $log .= "+ **" . $value . "** \n\n";
        // }
        $log .= "* * * \n\n";
        $user->log = $log . $old_log;
        $user->save();
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
