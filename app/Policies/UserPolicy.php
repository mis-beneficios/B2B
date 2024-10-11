<?php

namespace App\Policies;

use App\User;
use Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
     * @param  \App\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        $roles = array('admin', 'collector', 'control', 'conveniant', 'quality', 'recepcionist', 'reserver', 'sales', 'supervisor');

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
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        $roles = array('admin', 'collector', 'quality', 'control');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        if (Auth::user()->role == 'admin') {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function historial(User $user)
    {
        if (Auth::user()->role == 'admin') {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {

    }

    public function show_reservations(User $user)
    {
        // $roles = array('admin', 'collector', 'quality', 'reserver', 'control');
        // if (in_array($user->role, $roles)) {
            return true;
        // }
        // return false;
    }


    /*
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-06-12
     * Permiso para mostrar la vista de ventas
     */
    public function ver_ventas(User $user)
    {
        $roles = array('admin', 'conveniant', 'collector');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }
 
     /*
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-06-12
     * Permiso para mostrar la vista de alertas que se registran den la pagina de compra de la pagina web
     */
    public function ver_alertas(User $user)
    {
        $roles = array('admin', 'conveniant','supervisor');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    } 


    /*
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-06-12
     * Permiso para mostrar la vista de configuraciones
     */
    public function setting(User $user)
    {
        $roles = array('admin');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }



    /*
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-06-12
     * Permiso para mostrar la vista de los sorteos
     */
    public function sorteos(User $user)
    {
        $roles = array('admin','conveniant');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

    /*
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-06-12 
     * Permiso para mostrar la vista de las campañas
     */
    public function campanas(User $user)
    {
        $roles = array('admin', 'conveniant');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }
    /*
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-06-12 
     * Permiso para mostrar la vista del personal administrativo
     */
    public function show_admin(User $user)
    {
        $roles = array('admin');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

    /*
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-06-12 
     * Permiso para mostrar la vista de clientes
     */
    public function show_client(User $user)
    {
        $roles = array('admin');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }
    /*
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-06-12 
     * Permiso para mostrar la vista de equipos de ventas
     */
    public function show_salesgroup(User $user)
    {
        $roles = array('admin');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }
}
