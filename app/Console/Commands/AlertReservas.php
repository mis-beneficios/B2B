<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Log;
use Mail;
use App\Mail\PagoReservacionCliente;

class AlertReservas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificacion:clientes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar la notificacion de pago pendiente por reservacion a clientes';

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
        
        Log::info('Se han registrado '.count($datos). ' pago(s) pendient(es) a cliente(s)');

        foreach ($datos as $data) {
            Mail::to($data['email'])->send(new PagoReservacionCliente($data));
        }
        
        return $datos;
    }

    public function obtener_datos($fecha)
    {
         $res = DB::table('reservaciones as r')
            ->join('users as u', 'u.id', '=', 'r.user_id')
            ->join('convenios as cs', 'cs.id', '=', 'u.convenio_id')
            ->join('padres as p', 'p.id', '=', 'r.padre_id')
            ->join('users as u2', 'u2.id', '=', 'p.user_id')
            ->join('config_user as cu', 'cu.user_id', '=', 'p.user_id')
            ->select(
                DB::raw("p.id AS ID_EJECUTIVO"),
                DB::raw("u.id AS ID_CLIENTE"),
                DB::raw("UPPER(CONCAT (u.nombre, ' ',u.apellidos)) AS NOMBRE_CLIENTE"),
                DB::raw("u.username AS CORREO_CLIENTE"),
                DB::raw("r.estatus AS ESTATUS_RESERVACION"),
                DB::raw("cu.email AS CORREO_EJECUTIVO"),  
                DB::raw("cu.from_name AS NOMBRE_EJECUTIVO"),  
            )
            ->whereIn('r.estatus',['en proceso'])
            ->whereNotNull('r.admin_fecha_para_liquidar')
            ->whereRaw("r.fecha_limite_de_pago = DATE_ADD(DATE('{$fecha}'), INTERVAL 4 DAY)")
            ->where('r.cantidad','>', 0)
            ->where('cs.paise_id', 1)
            ->groupBy('r.user_id')
            ->get();

        $data = array();
        foreach ($res as $key => $val) {
            $res = DB::table('reservaciones as r')
                ->join('users as u', 'u.id', '=', 'r.user_id')
                ->join('convenios as cs', 'cs.id', '=', 'u.convenio_id')
                ->join('padres as p', 'p.id', '=', 'r.padre_id')
                ->join('users as u2', 'u2.id', '=', 'p.user_id')
                ->join('config_user as cu', 'cu.user_id', '=', 'p.user_id')
                ->select(
                    DB::raw("r.id AS FOLIO_RESERVACION"),
                    DB::raw("p.id AS ID_EJECUTIVO"),
                    DB::raw("u.id AS ID_CLIENTE"),
                    DB::raw("UPPER(CONCAT (u.nombre, ' ',u.apellidos)) AS NOMBRE_CLIENTE"),
                    DB::raw("u.username AS CORREO_CLIENTE"),
                    DB::raw("r.estatus AS ESTATUS_RESERVACION"),
                    DB::raw("cu.email AS CORREO_EJECUTIVO"),
                    DB::raw("cu.from_name AS NOMBRE_EJECUTIVO"),  
                    DB::raw("r.fecha_limite_de_pago AS FECHA_LIQUIDAR_HOTEL"),
                    DB::raw("r.hotel AS HOTEL"),
                    DB::raw("r.destino AS DESTINO"),
                    DB::raw("r.cantidad AS PAGO_A_REALIZAR"),
                )
                ->whereIn('r.estatus',['en proceso'])
                ->whereNotNull('r.admin_fecha_para_liquidar')
                ->whereRaw("r.fecha_limite_de_pago = DATE_ADD(DATE('{$fecha}'), INTERVAL 4 DAY)")
                ->where('r.cantidad','>', 0)
                ->where('cs.paise_id', 1)
                ->where('r.user_id', $val->ID_CLIENTE)
                // ->groupBy('r.user_id')
                ->get();

            $data[$key]['reservaciones']    = $res;
            $data[$key]['email']            = $val->CORREO_CLIENTE;
            $data[$key]['nombre']           = $val->NOMBRE_CLIENTE;
            $data[$key]['ejecutivo']        = $val->CORREO_EJECUTIVO;
            $data[$key]['nombre_ejecutivo'] = $val->NOMBRE_EJECUTIVO;
 
        }

        return $data;
    }
}