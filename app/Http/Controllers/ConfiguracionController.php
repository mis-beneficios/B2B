<?php

namespace App\Http\Controllers;

use App\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use DB;
use Auth;

class ConfiguracionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->authorize('setting', Auth::user());
        return view('admin.ajustes.index');
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
     * @param  \App\Configuracion  $configuracion
     * @return \Illuminate\Http\Response
     */
    public function show(Configuracion $configuracion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Configuracion  $configuracion
     * @return \Illuminate\Http\Response
     */
    public function edit(Configuracion $configuracion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Configuracion  $configuracion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Configuracion $configuracion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Configuracion  $configuracion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Configuracion $configuracion)
    {
        //
    }


    public function clear()
    {
        Artisan::call('optimize:clear');
        $data['success'] = true;

        return response()->json($data);
    }

    public function process()
    {
        return view('admin.ajustes.processlist');
    }

    public function listar_procesos()
    {
        $procesos = DB::select('show processlist');
        $datos    = json_decode(json_encode($procesos), true);

        $data = array();
        $i    = 1;
        $btn  = '';

        foreach ($datos as $val) {
            $data[] = array(
                "1" => '<div class="demo-checkbox"><input type="checkbox" id="proceso_'.$val['Id'].'" name="eliminiar[]" value="'.$val['Id'].'" class="filled-in chk-col-blue"><label for="proceso_'.$val['Id'].'"></label></div>',
                // "1" => '<input type="checkbox" name="eliminar[]" value="' . $val['Id'] . '">',
                "2" => $val['Id'],
                "3" => $val['User'],
                "4" => $val['Host'],
                "5" => $val['db'],
                "6" => $val['Command'],
                "7" => $val['Time'],
                "8" => $val['State'],
                "9" => $val['Info'],
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

    public function eliminar_procesos(Request $request)
    {
        $data['success'] = false;
        $procesos = $request->eliminar;
        if (is_array($procesos) || is_object($procesos))
        {
            $data['success'] = true;
            foreach ($procesos as $proceso) {
                // echo $proceso;
                DB::select('kill ' . $proceso);
            }
        }
        return response()->json($data);
    }

    public function kill_procesos()
    {
        $procesos = DB::select('show processlist');
        $datos    = json_decode(json_encode($procesos), true);

        foreach ($datos as $proceso) {
            DB::select('kill ' . $proceso['Id']);
        }

        return response()->json(['success' => 'true']);
    }


    public function almacenamiento()
    {
        return view('admin.ajustes.almacenamiento');
    }

}
