<?php

namespace App\Policies;

use App\Reservacion;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReservacionPolicy
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
    public function dashboard(User $user)
    {
        $roles = array('admin', 'reserver');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function filter(User $user)
    {
        $roles = array('admin', 'reserver');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        $roles = array('admin', 'quality', 'reserver', 'control', 'sales', 'supervisor');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Reservacion  $reservacion
     * @return mixed
     */
    public function view(User $user, Reservacion $reservacion)
    {
        $roles = array('admin', 'quality', 'reserver', 'control', 'sales', 'supervisor');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, Reservacion $reservacion)
    {
        $roles = array('reserver');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Reservacion  $reservacion
     * @return mixed
     */
    public function update(User $user)
    {
        $roles = array('admin', 'reserver');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Reservacion  $reservacion
     * @return mixed
     */
    public function delete(User $user, Reservacion $reservacion)
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
     * @param  \App\Reservacion  $reservacion
     * @return mixed
     */
    public function restore(User $user, Reservacion $reservacion)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Reservacion  $reservacion
     * @return mixed
     */
    public function forceDelete(User $user, Reservacion $reservacion)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Reservacion  $reservacion
     * @return mixed
     */
    public function pagos(User $user, Reservacion $reservacion)
    {
        $roles = array('admin', 'reserver');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Reservacion  $reservacion
     * @return mixed
     */
    public function cupon_confirmacion(User $user, Reservacion $reservacion)
    {
        $roles = array('admin', 'reserver');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Reservacion  $reservacion
     * @return mixed
     */
    public function cupon_cobro(User $user, Reservacion $reservacion)
    {
        $roles = array('admin', 'reserver');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Reservacion  $reservacion
     * @return mixed
     */
    public function habitaciones_contratos(User $user, Reservacion $reservacion)
    {
        $roles = array('admin', 'reserver');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Reservacion  $reservacion
     * @return mixed
     */
    public function asignar(User $user, Reservacion $reservacion)
    {
        $roles = array('admin', 'reserver');
        if (in_array($user->role, $roles) && $user->vetarifah == 1) {
            return true;
        }
        return false;
    }
    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Reservacion  $reservacion
     * @return mixed
     */
    public function reasignar(User $user, Reservacion $reservacion)
    {
        $roles = array('admin');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }
    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Reservacion  $reservacion
     * @return mixed
     */
    public function ajustes_reservacion(User $user, Reservacion $reservacion)
    {
        $roles = array('admin', 'reserver');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Reservacion  $reservacion
     * @return mixed
     */
    public function vetarifah(User $user)
    {
        $roles = array('admin', 'reserver');
        if (in_array($user->role, $roles)) {
            if ($user->vetarifah == 1) {
                return true;
            }
        }
        return false;
    }
    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2024-02-12
     * Determinamos si tiene permisos para ver el boton de info de la reservacion
     *
     * @param  \App\User  $user
     * @param  \App\Reservacion  $reservacion
     * @return mixed
     */
    public function bntInfo(User $user)
    {
        $roles = array('admin', 'reserver', 'collector', 'control');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

}
