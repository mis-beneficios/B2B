<?php

namespace App\Http\Controllers;

use App\Convenio;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Auth;

class CampanaController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $this->authorize('campanas', Auth::user());
        $all_convenios = Convenio::where('paise_id', config('app.pais_id'))->pluck('id', 'empresa_nombre');

        return view('admin.campanas.index', compact('all_convenios'));
    }

    public function store(Request $request)
    {
        $i = 0;
        foreach ($request->convenio_id as $con) {
            $convenio                 = Convenio::find($con);
            $convenio->campana_inicio = $request->fecha_inicio;
            $convenio->campana_fin    = $request->fecha_fin;

            $convenio->save();
            $i++;
        }

        $data['success'] = true;
        $data['cont']    = $i;

        return response()->json($data);
    }

    public function get_campanas()
    {

        $campanas = DB::select('select id, empresa_nombre, campana_inicio, campana_fin from convenios where CURRENT_DATE() BETWEEN campana_inicio and campana_fin and paise_id = 1 or CURRENT_DATE() <= campana_inicio order by empresa_nombre');

        $data     = array();
        $i        = 1;
        $btn      = '';
        $btnPagos = '';

        $hoy = Carbon::now()->addDay(3)->format('Y-m-d');
        // dd($hoy);
        foreach ($campanas as $campana) {
            $color  = ($campana->campana_fin <= $hoy) ? 'warning' : 'info';
            $data[] = array(
                "0" => $campana->id,
                "1" => $campana->empresa_nombre,
                "2" => '<span class="label label-info">' . $campana->campana_inicio . '</span>',
                "3" => '<span class="label label-' . $color . '">' . $campana->campana_fin . '</span>',
            );
            $btn = '';
        }
        //DEVUELVE LOS DATOS EN UN JSON
        $results = array(
            "sEcho"                => 1,
            "iTotalRecords"        => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData"               => $data,
        );
        return response()->json($results);
    }
}
