<?php

namespace App\Http\Controllers;

use App\Actividad;
use App\Concal;
use App\User;
use DB;
use Illuminate\Http\Request;

class ActividadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $this->authorize('viewAny', Actividad::class);
        return view('admin.actividades.index');
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
     * @param  \App\Actividades  $actividades
     * @return \Illuminate\Http\Response
     */
    public function show(Actividad $actividad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Actividad  $actividad
     * @return \Illuminate\Http\Response
     */
    public function edit(Actividad $actividad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Actividad  $actividad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Actividad $actividad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Actividad  $actividad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Actividad $actividad)
    {
        //
    }

    public function get_actividades(Request $request)
    {

        $desde = (!isset($request->desde)) ? date('Y-m-d') : $request->desde;
        $hasta = (!isset($request->hasta)) ? date('Y-m-d') : $request->hasta;

        $ejecutivos = DB::select("SELECT users.id as id, UPPER(CONCAT(users.nombre,' ',users.apellidos)) AS nombre, count(distinct actividades.id) AS actividades,
            count(distinct concals.id) as drive FROM users LEFT outer join actividades on users.id = actividades.user_id and actividades.modified between '" . $desde . "' and '" . $hasta . "'
            left outer join concals on users.id = concals.user_id and concals.modified between '" . $desde . " 00:00:01' and '" . $hasta . " 23:59:59'
            where users.actividades = 1  AND users.role IN ('conveniant') AND users.permitir_login=1
            group by users.id, users.nombre
            order by nombre, id;");

        $data = array();
        $i    = 1;

        foreach ($ejecutivos as $ejecutivo) {
            $data[] = array(
                "1" => $ejecutivo->nombre,
                "2" => '<button type="button" class="btn btn-dark btn-sm" id="btnActividad" data-desde="' . $desde . '" data-hasta="' . $hasta . '"  data-id="' . $ejecutivo->id . '">' . $ejecutivo->actividades . '</button>',
                "3" => '<button type="button" class="btn btn-dark btn-sm" id="btnDrive" data-desde="' . $desde . '" data-hasta="' . $hasta . '"  data-id="' . $ejecutivo->id . '">' . $ejecutivo->drive . '</button>',
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

    public function get_drive(Request $request)
    {

        $concals = Concal::where('user_id', $request->user_id)
            ->whereBetween('modified', [$request->desde . ' 00:00:01', $request->hasta . ' 23:59:59'])
            ->get();

        $user = User::findOrFail($request->user_id);

        $req             = $request->all();
        $data['success'] = true;
        $data['view']    = view('admin.actividades.elementos.drive', compact('concals', 'user', 'req'))->render();
        return response()->json($data);
    }
}
