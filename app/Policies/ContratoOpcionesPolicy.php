<?php

namespace App\Policies;

use App\Contrato;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
class ContratoOpcionesPolicy
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
    public function reenviar_contrato(User $user, Contrato $contrato)
    {
        $roles = array('admin', 'collector', 'quality', 'supervisor', 'control');
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
    public function mostrar_contrato(User $user, Contrato $contrato)
    {
        // $roles = array('admin', 'collector', 'quality', 'supervisor', 'control',);
        // if (in_array($user->role, $roles)) {
            return true;
        // }
        // return false;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function recalcular_contrato(User $user, Contrato $contrato)
    {

        $roles = array('admin', 'collector', 'control', 'quality', 'supervisor', 'sales');
        if (in_array($user->role, $roles)) {
            if ($user->role == 'sales' || $user->role == 'supervisor' && count($contrato->pagos_contrato) > 1) {
                return false;
            }
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
    public function convertir_estancia(User $user, Contrato $contrato)
    {
        $roles = array('admin', 'collector', 'quality');
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
    public function editar_contrato(User $user, Contrato $contrato)
    {
        $roles = array('admin', 'collector', 'quality', 'control');
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
    public function metodo_de_pago(User $user, Contrato $contrato)
    {
        $roles = array('admin', 'collector');
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
    public function agregar_pago(User $user, Contrato $contrato)
    {
        $roles = array('admin', 'collector');
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
    public function autorizar_folio(User $user, Contrato $contrato)
    {
        $roles = array('control', 'quality', 'admin');
        if (in_array($user->role, $roles)) {
            if ($contrato->estatus == 'por_autorizar') {
                return true;
            }
        }
        return false;
    }

    /**
     * Elimina el contrato seleccionado.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user, Contrato $contrato)
    {
        $roles = array('admin');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

    // Panel Cliente
    public function contrato_cliente(User $user, Contrato $contrato)
    {
        return $user->id === $contrato->user_id;
    }

    // public function create(User $user)
    // {
    //     $roles = array('', '');
    //     if (in_array($user->role, $roles)) {
    //         return true;
    //     }
    //     return false;
    // }

    /**
     * Cambiar vendedor del contrato.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function cambiar_vendedor(User $user)
    {
        $roles = array('admin');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }


    /**
     * Cargar imagenes de calidad como respaldo de la compra.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function calidad(User $user, Contrato $contrato)
    {

        $roles = array('supervisor', 'sales','admin');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

    /**
     * Cargar imagenes de calidad como respaldo de la compra.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function ver_calidad(User $user, Contrato $contrato)
    {

        $roles = array('quality','admin');
        if (in_array($user->role, $roles)) {
            return true;
        }
        return false;
    }

}
