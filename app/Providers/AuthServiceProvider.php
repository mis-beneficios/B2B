<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\User'       => 'App\Policies\UserPolicy',
        'App\Tarjeta'    => 'App\Policies\TarjetaPolicy',
        // 'App\Contrato' => 'App\Policies\ClienteContratoPolicy',
        'App\Contrato'   => 'App\Policies\ContratoOpcionesPolicy',
        'App\Pago'       => 'App\Policies\PagosPolicy',
        'App\Convenio'   => 'App\Policies\ConveniosPolicy',
        'App\Salesgroup' => 'App\Policies\Salesgroup',
        'App\Comision'   => 'App\Policies\ComisionPolicy',
        'App\Reservacion'=> 'App\Policies\ReservacionPolicy',
        'App\cobranza'   => 'App\Policies\CobranzaPolicy',
        'App\Banco'      => 'App\Policies\BancoPolicy',
        'App\Region'     => 'App\Policies\RegionPolicy',
        'App\Actividades'=> 'App\Policies\ActividadesPolicy',

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
