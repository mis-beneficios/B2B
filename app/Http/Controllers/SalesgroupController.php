<?php

namespace App\Http\Controllers;

use App\Salesgroup;
use App\User;
use Auth;
use Illuminate\Http\Request;

class SalesgroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('show_salesgroup', Auth::user());
        return view('admin.equipos.index');
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
     * @param  \App\Salesgroup  $salesgroup
     * @return \Illuminate\Http\Response
     */
    public function show(Salesgroup $salesgroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Salesgroup  $salesgroup
     * @return \Illuminate\Http\Response
     */
    public function edit(Salesgroup $salesgroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Salesgroup  $salesgroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Salesgroup $salesgroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Salesgroup  $salesgroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salesgroup $salesgroup)
    {
        //
    }

    public function listar_grupos()
    {
        $grupos = Salesgroup::all();
        $data   = array();
        $btn    = '';
        foreach ($grupos as $grupo) {
            $cont = count($grupo->ejecutivo);

            $btn .= '<button class="btn btn-info btn-xs mr-1" value="' . $grupo->id . '" id="btnAsociar" type="button"><i class="fas fa-link"></i></button>';
            
            $btn .= '<button class="btn btn-success btn-xs mr-1" value="' . $grupo->id . '" id="btnEditarGrupo" type="button"><i class="fas fa-edit"></i></button>';

            $btn .= '<button class="btn btn-danger btn-xs" value="' . $grupo->id . '" id="btnEliminarGrupo" type="button"><i class="fas fa-trash"></i></button>';

            $data[] = array(
                "0" => $grupo->id,
                "1" => $grupo->title,
                "2" => number_format($grupo->ventas, 2),
                "3" => number_format($grupo->supervisor, 2),
                "4" => $btn,
                "5" => '<button type="button" class="btn btn-dark btn-xs" id="btnUsersGrupo" data-grupo_id="' . $grupo->id . '"><i class="fas fa-user"></i> ' . $cont . '  Usuarios</button>',
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


    public function ver_usuarios_grupo($grupo_id)
    {
        $usuarios = salesgroup::findOrFail($grupo_id)->ejecutivo;

        $data['view'] = view('admin.equipos.listar_ejecutivos', compact('usuarios'))->render();

        return response()->json($data);
        
    }

    public function mostrar_ejecutivos($equipo_id = null)
    {
        // $equipo_id = Auth::user()->salesgroup_id;
        // $equipo_id = Salesgroup::where('user_id', Auth::id())->get();

        // dd($equipo_id);

        // if (empty($equipo_id)) {
        //     abort(403);
        // }

        // $ejecutivos = User::with([
        //             'admin_padre',
        //         ])->where('salesgroup_id', $equipo_id)->where('role', 'sales')->get();

        $ejecutivos = User::with(['admin_padre'])->whereHas('equipo', function($query){
            return $query->where('user_id', Auth::id())->orderBy('title', 'DESC');
        })
        ->where('role','sales')
        ->get();
        // var_dump($ejecutivos);
        // dd($ejecutivos);
        return view('admin.equipos.ejecutivos', compact('ejecutivos'));
    }

    public function asociar_ejecutivos($id)
    {
        $equipo = Salesgroup::findOrFail($id);

        $ejecutivos = User::where('salesgroup_id', $id)->get();
        $sin_asignar = User::where('salesgroup_id', null)->whereIn('role', ['supervisor', 'sales'])->orderBy('id','desc')->get();

        $data['view'] = view('admin.equipos.asociar_ejecutivos', compact('equipo', 'ejecutivos','sin_asignar'))->render();

        return response()->json($data);
    }

    public function vincular_ejecutivos(Request $request)
    {
        $data['success'] = false;
        $cont = 0;
        foreach ($request->ejecutivo as $key => $value) {
            $cont++;
            User::where('id', $value)->update(['salesgroup_id' => $request->equipo_id]);
        }

        if ($cont != 0) {
            $data['cont']       = $cont;
            $data['success']    = true;
        }

        return response()->json($data);
    }

    public function desvincular_ejecutivos($id)
    {
        $data['success'] = false;
        $user = User::where('id', $id)->update(['salesgroup_id' => null]);
        if ($user) {
            $data['success'] = true;
        }

        return response()->json($data);
    }
}
