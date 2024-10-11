<?php

namespace App\Http\Controllers\Cliente;

use App\Contrato;
use App\Http\Controllers\Controller;
use App\Pago;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class ContratosController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cliente.contratos.index');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return view('errors.construccion');
        // die();
        //

        $contrato = Contrato::where('id', $id)->first();

        // dd($contrato->reservaciones[0]->contratos);
        // if (isset($contrato->r_reservacion[0]) && !empty($contrato->r_reservacion[0])) {
        //     foreach ($contrato->r_reservacion[0]->r_contratos as $con) {
        //         $con_res[] = $con->id;
        //     }
        // } else {
        //     $con_res[] = false;
        // }

        if (isset($contrato->reservaciones[0]) && !empty($contrato->reservaciones[0])) {
            foreach ($contrato->reservaciones[0]->contratos as $con) {
                $con_res[] = $con->id;
            }
        } else {
            $con_res[] = false;
        }

        // dd($con_res, $contrato);

        $this->authorize('contrato_cliente', $contrato);

        $contratos = Contrato::with(['reservaciones'])->where("user_id", Auth::id())->whereIn("estatus", ['Comprado', 'por_autorizar', 'sin_aprobar'])->get();

        $allContrato = [];
        foreach ($contratos as $value) {
            // echo "<br/>";
            // echo $value->estancia_id;
            // echo "<br/>";
            if ($contrato->estancia_id == $value->estancia_id && count($value->r_reservacion) == null) {
                $allContrato[] = [
                    'id'          => $value->id,
                    'user_id'     => $value->user_id,
                    'convenio_id' => $value->convenio_id,
                    'estancia_id' => $value->estancia_id,
                    "paquete"     => $value->paquete,
                    "estatus"     => $value->estatus,
                ];
            }
        }

        // $temporadas = Temporada::select(DB::raw('date(fecha_de_inicio) = YEAR(NOW())'))->get();
        $temporadas = DB::select('select * from temporadas where YEAR(fecha_de_inicio) in (YEAR(NOW())) and MONTH(fecha_de_inicio) >= MONTH(NOW())');
        $data_temp  = [];
        foreach ($temporadas as $temporada) {
            $data_temp[] = [
                'id'        => $temporada->id,
                "temporada" => $temporada->title,
                'fecha'     => Carbon::parse($temporada->fecha_de_inicio)->format('d-m-Y') . ' al ' . Carbon::parse($temporada->fecha_de_termino)->format('d-m-Y'),
            ];
        }

        $pagado = Pago::where(['contrato_id' => $contrato->id, 'estatus' => 'Pagado'])->sum('cantidad');
        return view('cliente.contratos.show', compact('contrato', 'pagado', 'allContrato', 'con_res', 'data_temp'));
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
}
