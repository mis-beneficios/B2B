<?php

namespace App\Providers;

use App\Banco;
use App\Convenio;
use App\Destino;
use App\Estancia;
use App\Observers\ReservacionObserver;
use App\Observers\UserObserver;
use App\Pais;
use App\Region;
use App\User;
use App\Reservacion;
use Illuminate\Support\ServiceProvider;
use Cache;
use Illuminate\Support\Facades\View;
use App\Configuracion;
use App\Notificacion;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BeneficiosServiceProvider extends ServiceProvider
{

    const EXPTIME = 3600;
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        // $notificaciones = Notificacion::where('estatus', 0)->get();

        // foreach ($notificaciones as $notificacion) {
        //     if (!Cookie::has($notificacion->key_cache)) {
        //         $fecha1 = Carbon::now();
        //         $fecha2 = Carbon::create($notificacion->activo_hasta);
        //         $diferenciaEnMinutos = $fecha1->diffInMinutes($fecha2);
        //         setcookie($notificacion->key_cache, 'false', time() + $diferenciaEnMinutos * 60, '/');
        //     }
        // }

        /**
         * Observadores
         */
        // Reservacion::observe(ReservacionObserver::class);

        /**
         * Cargar variable globales en session para optimizar la carga de datos
         */
        // session(['unlock_cards' => false]);

        //$this->register_mx();

        //view()->composer('*', function ($view) {
        $register         = self::register_mx();
        $bancos_mx        = self::bancos_mx();
        $estancias_global = self::estancias();
        $regiones         = self::regiones();
        $destinos         = self::destinos();
        $paises           = self::paises();
        $convenios_mx     = self::convenios_mx();

        // $notificaciones   = Notificacion::where('estatus', 0)->get();

        // Imagen de fondo de login
        $config = Configuracion::where('name', 'background_image')->first();
        $back_image = ($config != null && $config->data != null) ? $config->data : 'images/fondos/back2.jpg';

        // Imagen de preload
        $config_img = Configuracion::where('name', 'preload_image')->first();
        $preload_image =  ($config_img != null && $config_img->data != null) ? $config_img->data : 'images/icono01.png';


        // Calendario de temporadas
        $config_calendario = Configuracion::where('name', 'calendario_temporadas')->first();
        $cal_temp = ($config_calendario != null && $config_calendario->data != null) ? $config_calendario->data : 'images/calendario_beneficios_2022-2023.jpg';


        /**
         * carga de datos estatitcs para el funcionamiento de algunas funciones
         */

        $roles = array(
            'admin'        => 'Administrador',
            'client'       => 'Cliente',
            'recepcionist' => 'Recepcionista',
            'supervisor'   => 'Supervisor de Ventas',
            'sales'        => 'Ejecutivo de Ventas',
            'collector'    => 'Ejecutivo de Cobranza',
            'reserver'     => 'Ejecutivo de Reservaciones',
            'conveniant'   => 'Generador de Convenios',
            'quality'      => 'Control de Calidad',
            'control'      => 'Control de Ventas',
        );

        $tipo_pago = array(
            'semanal'           => 'SEMANAL: Un día por semana',
            'catorcenal'        => 'CATORCENAL: Un día por semana intercalada',
            'quincenal_preciso' => 'QUINCENAL PRECISO',
            'quincenal_clasico' => ' QUINCENAL CLÁSICO: Cada siguiente dia 15 o último del mes',
            'mensual'           => '   MENSUAL: Cada cierto día del mes',
        );

        $como_se_entero = array(
            // 1  => 'redes sociales',
            // 2  => 'correo electronico',
            3  => 'Búsqueda WEb',
            4  => 'Flyer promocional',
            5  => 'Recomendación',
            6  => 'Otros',
            7  => 'Llamada telemarketing',
            8  => 'Venta directa',
            // 9  => 'whatsapp',
            10 => 'Gopacific',
            11 => 'Transporte publico',
            12 => 'IMSS - CLM',
            13 => 'Redes Sociales',
            20 => 'Amando a México',
        );

        $cuotas = array(
            1  => '1',
            12 => '12',
            24 => '24',
            48 => '48',
            36 => '36',
            72 => '72',
        );

        $divisas = array(
            'MXN' => 'MXN',
            'USD' => 'USD',
        );

        $estatus_tarjetas = array(
            'Cancelada'        => 'Cancelada',
            'No Aprobada'      => 'No Aprobada',
            'Confirmada'       => 'Confirmada',
            'Extraviada'       => 'Extraviada',
            'Denegada'         => 'Denegada',
            'Al Dia'           => 'Al Día',
            'Rechazada'        => 'Rechazada',
            'Inexistente'      => 'Inexistente',
            'Erronea'          => 'Errónea',
            'Retener'          => 'Retener',
            'Emisor Invalido'  => 'Emisor Invalido',
            'Bloqueada'        => 'Bloqueada',
            'Tarjeta Vencida'  => 'Tarjeta Vencida',
            'Tarjeta Invalida' => 'Tarjeta Invalida',
            'Declinada'        => 'Declinada',
        );

        $estatus_pagos = array(
            'Por Pagar'  => 'Por Pagar',
            'Pagado'     => 'Pagado',
            'Rechazado'  => 'Rechazado',
            'Cancelado'  => 'Cancelado',
            'Bonificado' => 'Bonificado',
            'Anomalia'   => 'Anomalía',
            'pagado_fdt' => 'Pago fuera de tiempo',
            'Simulador'  => 'Simulador',
        );

        $estatus_concal = array(
            'enviada'       => 'Enviada',
            'por_cerrar'    => 'Por cerrar',
            'no_contactado' => 'No contactado',
            'cerrado'       => 'Cerrado',
            'rechazada'     => 'Rechazada',
            'seguimiento'   => 'Seguimiento',
            'retomar'       => 'Retomar',
            'interesado'    => 'Interesado',
            'ellos_llaman'  => 'Ellos llaman',
        );

        /**
         * Reservaciones
         */
        /*$tipo_reservacion = array(
                'venta'          => 'Venta',
                'referido'       => 'Cortesía referidos',
                'campana'        => 'Cortesía campaña',
                'reconocimiento' => 'Cortesía reconocimiento',
                'vuelo'          => 'Vuelo',
                'traslado'       => 'Traslado',
                'tour'           => 'Tour',
                'autobus'        => 'Autobús',
            );

            $estatus_reservacion = array(
                'Nuevo'         => 'Nuevo - NC',
                'Ingresada'     => 'Ingresada - NR',
                'En proceso'    => 'En proceso - EP',
                'Cupon Enviado' => 'Cupón Enviado - CE',
                'Cancelada'     => 'Cancelada - CA',
                'Penalizada'    => 'Penalizada - PN',
                'Revision'      => 'Revisión - RE',
                'Autorizada'    => 'Autorizada - OK',
                'Seguimiento'   => 'Seguimiento - SG',
            );

            $estatus_pago = array(
                '0' => 'Pendientes',
                '1' => 'Pagadas',
            );

            $garantia_reservacion = array(
                '0' => 'Sin garantizar',
                '1' => 'Garantizada',
            );

            $tipo_garantia = array(
                'Carta'   => 'Carta',
                'Dinero'  => 'Dinero',
                'Tarjeta' => 'Tarjeta',
            );

            $filtros_fecha = array(
                0 => 'Ingreso',
                1 => 'Alta',
                2 => 'Pago Hotel',
                3 => 'Pago Cliente',
            );
            $tipo_estancia = array(
                'estancia'  => 'Estancia',
                'grupo'     => 'Grupo',
                'casa'      => 'Casa',
            );
            */


        session(['config' => [
            'estancias_global'     => $estancias_global->toArray(),
            'bancos_mx'            => $bancos_mx->toArray(),
            'register'             => $register,
            'roles'                => $roles,
            'como_se_entero'       => $como_se_entero,
            'cuotas'               => $cuotas,
            'divisas'              => $divisas,
            'estatus_tarjetas'     => $estatus_tarjetas,
            'estatus_pagos'        => $estatus_pagos,
            'estatus_concal'       => $estatus_concal,
            'destinos'             => $destinos,
            'regiones'             => $regiones,
            'paises'               => $paises->toArray(),
            //'tipo_reservacion'     => $tipo_reservacion,
            //'estatus_reservacion'  => $estatus_reservacion,
            //'estatus_pago'         => $estatus_pago,
            //'garantia_reservacion' => $garantia_reservacion,
            //'filtros_fecha'        => $filtros_fecha,
            //'tipo_garantia'        => $tipo_garantia,
            'convenios'            => $convenios_mx->toArray(),
            'tipo_pago_g'          => $tipo_pago,
            'back_image'           => $back_image,
            'preload_image'        => $preload_image,
            'cal_temp'             => $cal_temp,
            'tipo_estancia'        => $tipo_estancia,
            // 'notificaciones'       => $notificaciones,
        ]]);
        // });
    }

    /**
     * Autor: ISW. Diego Enrique Sanchez
     * Creado: 2022-12-26
     * Cargamos las estancias del pais ingresado en el evn
     * Almacenandolos en cache para la carga optimizada
     * @return estancias
     */
    private static function estancias()
    {
        //return Cache::remember('estancias_global', self::EXPTIME, function () {
        return  Estancia::where(['habilitada' => 1, 'estancia_paise_id' => env('APP_PAIS_ID', 1)])->select('id', 'title', 'precio', 'habilitada', 'descripcion', 'noches', 'adultos', 'ninos', 'divisa', 'cuotas')->orderBy('id', 'DESC')->get();
        //});
    }

    /**
     * Autor: ISW. Diego Enrique Sanchez
     * Creado: 2022-12-26
     * cookie de validacion de pre registro de usuario en la pagina web
     * Almacenandolos en cache para la carga optimizada
     * @return register
     */
    private static function register_mx()
    {
        if (env('APP_ENV') == 'production') {
            view()->composer('*', function ($view) {
                $register    = (isset($_COOKIE['preregister'])) ? $_COOKIE['preregister'] : false;
                $register_mx = (isset($_COOKIE['preregister_mx'])) ? $_COOKIE['preregister_mx'] : false;
                $view->with(['register' => $register, 'register_mx' => $register_mx]);
            });
        } else {
            view()->composer('*', function ($view) {
                $view->with(['register' => true, 'register_mx' => true]);
            });
        }
    }

    /**
     * Autor: ISW. Diego Enrique Sanchez
     * Creado: 2022-12-26
     * Cargamos los bancos del pais ingresao en el env
     * Almacenandolos en cache para la carga optimizada
     * @return estancias
     */
    private static function bancos_mx()
    {
        //return Cache::remember('bancos_mx', self::EXPTIME, function () {
        return Banco::where('paise_id', env('APP_PAIS_ID'))->get(['id', 'title']);
        //});
    }

    /**
     * Autor: ISW. Diego Enrique Sanchez
     * Creado: 2022-12-26
     * Cargamos los convenios del pais ingresao en el env
     * Almacenandolos en cache para la carga optimizada
     * @return estancias
     */
    private static function convenios_mx()
    {
        //return Cache::remember('convenios_mx', self::EXPTIME, function () {
        return Convenio::where('paise_id', env('APP_PAIS_ID'))->get(['id', 'empresa_nombre', 'llave']);
        //});
    }

    /**
     * Autor: ISW. Diego Enrique Sanchez
     * Creado: 2022-12-26
     * Cargamos los destinos
     * Almacenandolos en cache para la carga optimizada
     * @return estancias
     */
    private static function destinos()
    {
        //return Cache::remember('destinos', self::EXPTIME, function () {
        return Destino::pluck('id', 'titulo');
        //});
    }
    /**
     * Autor: ISW. Diego Enrique Sanchez
     * Creado: 2022-12-26
     * Cargamos las regiones
     * Almacenandolos en cache para la carga optimizada
     * @return estancias
     */
    private static function regiones()
    {
        //return Cache::remember('regiones', self::EXPTIME, function () {
        return Region::pluck('id', 'title');
        //});
    }

    /**
     * Autor: ISW. Diego Enrique Sanchez
     * Creado: 2022-12-26
     * Cargamos las regiones
     * Almacenandolos en cache para la carga optimizada
     * @return estancias
     */
    private static function paises()
    {

        //return Cache::remember('paises', self::EXPTIME, function () {
        return Pais::get(['id', 'title']);
        //});
    }


    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-10-13
     * Consultamos los registros de notificaciones que se encuentran activos para cargar la llave del cache en el navegador y poder visualizar la modal con la informacion de la notificacion
     * @return 
     */
    private static function notificaciones()
    {
        $notificaciones = Notificacion::where('estatus', 0)->get();
        foreach ($notificaciones as $notificacion) {
            setcookie('cookie_' . $notificacion->key_cache, 'false', time() + self::EXPTIME * 5, '/');
        }
    }
}
