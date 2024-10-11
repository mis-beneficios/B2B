<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Mail\RecordatorioReservaciones;
use Log;
use Mail;

class AlertUserReservas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificacion:reservaciones';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notificación de pagos pendientes a personal de reservaciones';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $fecha = date('Y-m-d');
        $datos = $this->obtener_datos($fecha);
        Log::info('Se han registrado '.count($datos). ' pago(s) pendiente(s) a reservacion(es)');

        foreach ($datos as $data) {
            Mail::to($data['email'])->send(new RecordatorioReservaciones($data));
        }
        
        return $datos;
    }

    public function obtener_datos($fecha)
    {
         $res = DB::table('reservaciones as r')
            ->join('padres as p', 'p.id', '=', 'r.padre_id')
            ->join('users as u2', 'u2.id', '=', 'p.user_id')
            ->join('config_user as cu', 'cu.user_id', '=', 'p.user_id')
            ->select(
                DB::raw("p.id AS ID_EJECUTIVO"),
                DB::raw("cu.email AS CORREO_EJECUTIVO"),  
                DB::raw("cu.from_name AS NOMBRE_EJECUTIVO"),  
            )
            ->whereIn('r.estatus',['en proceso'])
            ->whereNotNull('r.admin_fecha_para_liquidar')
            ->whereRaw("r.admin_fecha_para_liquidar = DATE_ADD(DATE('{$fecha}'), INTERVAL 5 DAY)")
            ->where('r.cantidad_pago','>', 0)
            ->groupBy('p.user_id')
            ->get();


        $data = array();
        foreach ($res as $key => $val) {
            $res = DB::table('reservaciones as r')
                ->join('users as u', 'u.id', '=', 'r.user_id')
                ->join('convenios as cs', 'u.convenio_id', '=', 'cs.id')
                ->join('padres as p', 'p.id', '=', 'r.padre_id')
                ->join('users as u2', 'u2.id', '=', 'p.user_id')
                ->join('config_user as cu', 'cu.user_id', '=', 'p.user_id')
                ->select(
                    DB::raw("r.id as FOLIO_RESERVACION"),
                    DB::raw("UPPER(CONCAT (u.nombre, ' ',u.apellidos)) AS NOMBRE_CLIENTE"),
                    // DB::raw("p.user_id AS ID_EJECUTIVO"),
                    DB::raw("p.id AS ID_EJECUTIVO"),
                    DB::raw("cu.email AS CORREO_EJECUTIVO"),
                    DB::raw("UPPER( CONCAT (u2.nombre, ' ',u2.apellidos)) AS NOMBRE_EJECUTIVO"),
                    DB::raw("r.estatus AS ESTATUS_RESERVACION"),
                    DB::raw("r.admin_fecha_para_liquidar AS FECHA_LIQUIDAR_HOTEL"),
                    DB::raw("r.cantidad_pago AS TARIFA_HOTEL"),
                    DB::raw("r.destino AS DESTINO"),
                    DB::raw("r.hotel AS HOTEL"),                     
                )
                ->whereIn('r.estatus',['en proceso'])
                ->whereNotNull('admin_fecha_para_liquidar')
                ->whereRaw("r.admin_fecha_para_liquidar = DATE_ADD(DATE('{$fecha}'), INTERVAL 5 DAY)")
                ->where('r.cantidad_pago','>', 0)
                ->where('r.padre_id', $val->ID_EJECUTIVO)
                ->get();

            $data[$key]['reservaciones']=$res;
            $data[$key]['email']=$val->CORREO_EJECUTIVO;
            $data[$key]['nombre']=$val->NOMBRE_EJECUTIVO;
 
        }

        return $data;
    }
}


 // $res = DB::table('reservaciones as r')
 //            ->join('users as u', 'u.id', '=', 'r.user_id')
 //            ->join('convenios as cs', 'u.convenio_id', '=', 'cs.id')
 //            ->join('padres as p', 'p.id', '=', 'r.padre_id')
 //            ->join('users as u2', 'u2.id', '=', 'p.user_id')
 //            ->join('config_user as cu', 'cu.user_id', '=', 'p.user_id')
 //            ->select(
 //                DB::raw("r.id as FOLIO_RESERVACION"),
 //                DB::raw("UPPER(CONCAT (u.nombre, ' ',u.apellidos)) AS NOMBRE_CLIENTE"),
 //                // DB::raw("p.user_id AS ID_EJECUTIVO"),
 //                DB::raw("p.id AS ID_EJECUTIVO"),
 //                DB::raw("cu.email AS CORREO_EJECUTIVO"),
 //                DB::raw("UPPER( CONCAT (u2.nombre, ' ',u2.apellidos)) AS NOMBRE_EJECUTIVO"),
 //                DB::raw("r.estatus AS ESTATUS_RESERVACION"),
 //                DB::raw("r.admin_fecha_para_liquidar AS FECHA_LIQUIDAR_HOTEL"),
 //                DB::raw("r.cantidad_pago AS TARIFA_HOTEL"),
 //                DB::raw("r.destino AS DESTINO"),
 //                DB::raw("r.hotel AS HOTEL"),                    
                    
 //            )
 //            ->whereIn('r.estatus',['en proceso'])
 //            ->whereNotNull('admin_fecha_para_liquidar')
 //            ->whereRaw("r.admin_fecha_para_liquidar = DATE_ADD(DATE('{$fecha}'), INTERVAL 5 DAY)")
 //            ->where('r.cantidad_pago','>', 0)
 //            ->groupBy('p.user_id')
 //            ->get();