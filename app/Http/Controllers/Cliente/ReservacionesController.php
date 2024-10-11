<?php

namespace App\Http\Controllers\Cliente;

use App\Contrato;
use App\ContratosReservaciones as CR;
use App\Habitacion;
use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Region;
use App\Reservacion;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Log;
use Yajra\DataTables\DataTables;

class ReservacionesController extends Controller
{
    private $log;

    public function __construct()
    {
        $this->middleware('auth');
        $this->log = new LogHelper;
    }

    public function validar_form(Request $request, $id = null)
    {

        $validator = \Validator::make($request->all(), [
            'folio'               => 'required',
            'nombre_adquisitor'   => 'required',
            'ciudad'              => 'required',
            'convenio_id'         => 'required',
            'titular_reservacion' => 'required',
            'destino'             => 'required',
            'fecha'               => 'required',
            'adultos'             => 'required',
            'precio_paquete'      => 'required',
            'plan'                => 'required',
            'telefono'            => 'required',
            'correo'              => 'required',
            // 'comentario'          => 'required',

        ]);

        return $validator;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cliente.reservaciones.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            DB::beginTransaction();

            $res['success'] = false;
            $validate       = $this->validar_form($request);
            if ($validate->fails()) {
                return response()->json(['success' => false, 'errors' => $validate->errors()]);
            }

            $fecha        = explode(' al ', $request->fecha);


            $fechaIngreso = Carbon::parse($fecha[0])->format('Y-m-d');
            $fechaSalida  = Carbon::parse($fecha[1])->format('Y-m-d');
            $contratos    = Contrato::where("id", $request->folio)->first();
            // dd($request->fecha, $fecha, $fechaIngreso, $fechaSalida);
            // dd($request->folio, $contratos);

            $region = Region::where('paise_id', $contratos->convenio->paise_id)->first();
            $now    = Carbon::now()->format('Y-m-d h:i:s');

            $reservacion                                      = new Reservacion();
            $reservacion->title                               = $contratos->estancia->title;
            $reservacion->user_id                             = Auth::user()->id;
            $reservacion->convenio_id                         = $request->convenio_id;
            $reservacion->estatus                             = "Nuevo";
            $reservacion->regione_id                          = $region->id;
            $reservacion->estancia_id                         = $contratos->estancia_id;
            $reservacion->fecha_de_ingreso                    = $fechaIngreso;
            $reservacion->fecha_de_salida                     = $fechaSalida;
            $reservacion->destino                             = $request->destino;
            $reservacion->nombre_de_quien_sera_la_reservacion = $request->nombre_adquisitor;
            $reservacion->hotel                               = "";
            $reservacion->habitaciones                        = 1;
            $reservacion->created                             = $now;
            $reservacion->tipo                                = 'venta';
            $reservacion->telefono                            = $request->telefono;
            $reservacion->email                               = $request->correo;
            if ($request->user_temporada_alta == 1) {
                $reservacion->log = 'Usuario a seleccionado temporada alta, para recalculo y ajuste de costo asi como validar las fechas de ingreso.';
            }

            if ($reservacion->save()) {
                /**
                 * Observador lanzado al momento de guardar la reservacion
                 * revisar observadores ReservacionObserver method created
                 */

                $cr                  = new CR();
                $cr->contrato_id     = $request->contrato_id;
                $cr->reservacione_id = $reservacion->id;
                if ($cr->save()) {
                    Contrato::where('id', $request->contrato_id)->update(['estatus' => 'viajado']);

                    Log::notice('Nueva reservacion por parte del cliente: ' . Auth::user()->fullName . ' - ' . Auth::user()->username . ' reservacion con folio: ' . $reservacion->id);
                    $this->log->add_log_reservacion(Auth::user(), 'Nota', $reservacion);
                    Log::notice("Folio: $request->contrato_id asociado a la reservacion $reservacion->id");
                }

                if ($this->crear_habitacion($request, $contratos, $reservacion->id)) {
                    foreach ($request->folio as $folio) {
                        if ($request->contrato_id != $folio) {

                            $cr                  = new CR();
                            $cr->contrato_id     = ($request->contrato_id != $folio) ? $folio : $request->contrato_id;
                            $cr->reservacione_id = $reservacion->id;
                            if ($cr->save()) {
                                Contrato::where('id', $folio)
                                    ->update(['estatus' => 'viajado']);

                                Log::notice("Folio: $folio asociado a la reservacion $reservacion->id");
                            }
                        }
                    }
                    return response()->json(['success' => true]);
                }
            } else {
                DB::rollback();
                return response()->json(['success' => false]);
            }

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function crear_habitacion($request, $contratos, $reservacion_id)
    {
        $fecha        = explode(' al ', $request->fecha);
        $fechaIngreso = Carbon::parse($fecha[0])->format('Y-m-d');
        $fechaSalida  = Carbon::parse($fecha[1])->format('Y-m-d');
        $now          = Carbon::now()->format('Y-m-d h:i:s');

        $habitacion                   = new Habitacion();
        $habitacion->user_id          = Auth::id();
        $habitacion->padre_id         = $contratos->padre->id;
        $habitacion->estancia         = $contratos->estancia->title;
        $habitacion->reservacione_id  = $reservacion_id;
        $habitacion->noches           = $contratos->estancia->noches;
        $habitacion->adultos          = $request->adultos;
        $habitacion->menores          = ($request->edad_nino) ? count($request->edad_nino) : 0;
        $habitacion->juniors          = ($request->edad_junior) ? count($request->edad_junior) : 0;
        $habitacion->adultos_extra    = 0;
        $habitacion->menores_extra    = 0;
        $habitacion->fecha_de_ingreso = $fechaIngreso;
        $habitacion->fecha_de_salida  = $fechaSalida;
        if ($request->edad_nino) {
            switch (count($request->edad_nino)) {
                case 1:
                    $habitacion->edad_menor_1 = $request->edad_nino[0];
                    $habitacion->edad_menor_2 = 0;
                    $habitacion->edad_menor_3 = 0;
                    $habitacion->edad_menor_4 = 0;
                    $habitacion->edad_menor_5 = 0;
                    break;
                case 2:
                    $habitacion->edad_menor_1 = $request->edad_nino[0];
                    $habitacion->edad_menor_2 = $request->edad_nino[1];
                    $habitacion->edad_menor_3 = 0;
                    $habitacion->edad_menor_4 = 0;
                    $habitacion->edad_menor_5 = 0;
                    break;
                case 3:
                    $habitacion->edad_menor_1 = $request->edad_nino[0];
                    $habitacion->edad_menor_2 = $request->edad_nino[1];
                    $habitacion->edad_menor_3 = $request->edad_nino[2];
                    $habitacion->edad_menor_4 = 0;
                    $habitacion->edad_menor_5 = 0;
                    break;
                case 4:
                    $habitacion->edad_menor_1 = $request->edad_nino[0];
                    $habitacion->edad_menor_2 = $request->edad_nino[1];
                    $habitacion->edad_menor_3 = $request->edad_nino[2];
                    $habitacion->edad_menor_4 = $request->edad_nino[3];
                    $habitacion->edad_menor_5 = 0;
                    break;
                case 5:
                    $habitacion->edad_menor_1 = $request->edad_nino[0];
                    $habitacion->edad_menor_2 = $request->edad_nino[1];
                    $habitacion->edad_menor_3 = $request->edad_nino[2];
                    $habitacion->edad_menor_4 = $request->edad_nino[3];
                    $habitacion->edad_menor_5 = $request->edad_nino[4];
                    break;
            }
        }
        if ($request->edad_junior) {
            switch (count($request->edad_junior)) {
                case 1:
                    $habitacion->edad_junior_1 = $request->edad_junior[0];
                    $habitacion->edad_junior_2 = 0;
                    $habitacion->edad_junior_3 = 0;
                    $habitacion->edad_junior_4 = 0;
                    $habitacion->edad_junior_5 = 0;
                    break;
                case 2:
                    $habitacion->edad_junior_1 = $request->edad_junior[0];
                    $habitacion->edad_junior_2 = $request->edad_junior[1];
                    $habitacion->edad_junior_3 = 0;
                    $habitacion->edad_junior_4 = 0;
                    $habitacion->edad_junior_5 = 0;
                    break;
                case 3:
                    $habitacion->edad_junior_1 = $request->edad_junior[0];
                    $habitacion->edad_junior_2 = $request->edad_junior[1];
                    $habitacion->edad_junior_3 = $request->edad_junior[2];
                    $habitacion->edad_junior_4 = 0;
                    $habitacion->edad_junior_5 = 0;
                    break;
                case 4:
                    $habitacion->edad_junior_1 = $request->edad_junior[0];
                    $habitacion->edad_junior_2 = $request->edad_junior[1];
                    $habitacion->edad_junior_3 = $request->edad_junior[2];
                    $habitacion->edad_junior_4 = $request->edad_junior[3];
                    $habitacion->edad_junior_5 = 0;
                    break;
                case 5:
                    $habitacion->edad_junior_1 = $request->edad_junior[0];
                    $habitacion->edad_junior_2 = $request->edad_junior[1];
                    $habitacion->edad_junior_3 = $request->edad_junior[2];
                    $habitacion->edad_junior_4 = $request->edad_junior[3];
                    $habitacion->edad_junior_5 = $request->edad_junior[4];
                    break;
            }
        }
        $habitacion->created = $now;
        if ($habitacion->save()) {
            return true;
        }
        return false;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function obtener_reservaciones()
    {
        $reservaciones = Reservacion::where('user_id', Auth::user()->id)->get();

        return Datatables::of($reservaciones)
            ->addColumn('id', function ($reservaciones) {
                return $reservaciones->id;
            })
            ->addColumn('estatus', function ($reservaciones) {
                return $reservaciones->estatus;
            })
            ->addColumn('fecha_de_reservacion', function ($reservaciones) {
                return $reservaciones->fecha_de_ingreso . '-' . $reservaciones->fecha_de_salida;
            })
            ->editColumn('destino', function ($reservaciones) {
                return ($reservaciones->destino) ? $reservaciones->destino : 'N/A';
            })
            ->editColumn('hotel', function ($reservaciones) {
                return ($reservaciones->hotel) ? $reservaciones->hotel : 'N/A';
            })
            ->editColumn('estatus', function ($reservaciones) {
                return ($reservaciones->estatus) ? $reservaciones->estatus : 'N/A';
            })
        // ->addColumn('action', function ($reservaciones) {
        //     return '<a href="' . route('paquetes.show', $reservaciones->id) . '" data-id="' . $reservaciones->id . '"  id="btnVer" class="btn waves-effect waves-light btn-info btn-sm"><i class="fa fa-eye"></i></a> ' .
        //     '<a href="javascript:void(0)" data-id="' . $reservaciones->id . '"  id="btnPagos" class="btn waves-effect waves-light btn-success btn-sm"><i class="fa fa-dollar"></i></a> ' .
        //     '<a href="javascript:void(0)" data-id="' . $reservaciones->id . '"  id="btnContrato" class="btn waves-effect waves-light btn-warning btn-sm"><i class="fa fa-file-pdf-o"></i></a> ' .
        //     '<a href="javascript:void(0)" data-id="' . $reservaciones->id . '"  id="btnReservar" class="btn waves-effect waves-light btn-primary btn-sm"><i class="fa fa-calendar"></i></a> ';
        // })
            ->make(true);
    }

    public function getTemporada(Request $request)
    {

        try {
            $data['flag'] = true;
            $contrato     = Contrato::findOrFail($request->contrato_id);

            $data['temporada_con'] = $contrato->tipo_temporada();
            $data['dias_con']      = ($data['temporada_con'] == 'Alta') ? 60 : 30;

            $fecha        = explode(' al ', $request->fecha);
            $fechaIngreso = Carbon::parse($fecha[0])->format('Y-m-d');
            $fechaSalida  = Carbon::parse($fecha[1])->format('Y-m-d');

            $data['fecha_i']         = $fechaIngreso;
            $data['fecha_s']         = $fechaSalida;
            $data['dias_diferencia'] = Carbon::parse($fecha[0])->diffInDays(Carbon::now());

            $temporada = DB::select("select * from temporadas where date('$fechaIngreso') BETWEEN fecha_de_inicio and fecha_de_termino or date('$fechaSalida') BETWEEN fecha_de_inicio and fecha_de_termino order by title");

            $data['temporada'] = $temporada[0]->title;

            if ($temporada[0] != null) {

                switch ($temporada[0]->title) {
                    case 'ALTA':
                        $data['dias_temp'] = 60;
                        break;
                    case 'BAJA':
                        $data['dias_temp'] = 30;

                        break;
                    default:
                        $data['dias_temp'] = 60;
                        break;
                }
            }

            if ($data['temporada'] != $data['temporada_con']) {
                $data['flag']      = false;
                $data['message']   = 'Esta seleccionando una fecha en temporada alta';
                $data['message_2'] = '¿Desea continuar?, se realizara un ajuste por temporada';
            }
            // if ($data['dias_con'] < $data['dias_temp']) {
            //     $data['flag']      = true;
            //     $data['message']   = 'Esta seleccionando una fecha en temporada alta';
            //     $data['message_2'] = '¿Desea continuar?, se realizara un ajuste por temporada';
            // }

            $data['data_temporada'] = $temporada;
        } catch (Exception $e) {
            $data['errors'] = $e;
        }

        return response()->json($data);

    }
}
