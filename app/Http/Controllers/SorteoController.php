<?php

namespace App\Http\Controllers;

use App\Convenio;
use App\Exports\SorteoConvenioExport;
use App\Sorteo;
use App\SorteoConvenio;
use Auth;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;

class SorteoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function validar_form(Request $request, $id = null)
    {

        $validator = \Validator::make($request->all(), [
            'convenio_id'  => ($request->tipo_sorteo != 'multimedia')  ? 'required' : '',
            'llave'        => ($request->tipo_sorteo == 'multimedia')  ? 'required' : '',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after:fecha_inicio',

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
        $this->authorize('sorteos', Auth::user());
        return view('admin.sorteos.index');
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

        // dd($request->all());
        $res['success'] = false;
        $validate       = $this->validar_form($request);
        if ($validate->fails()) {
            return response()->json(['success' => false, 'errors' => $validate->errors()]);
        }
        $sorteo               = new Sorteo;

        $fecha_inicio = Carbon::parse($request->fecha_inicio)->format('Y-m-d');
        $fecha_fin    = Carbon::parse($request->fecha_fin)->format('Y-m-d');
        if ($request->tipo_sorteo != 'multimedia') {
            $convenio     = Convenio::findOrFail($request->convenio_id);
            $sorteo->convenio     = $convenio->empresa_nombre;
            $sorteo->llave        = $convenio->llave;
            $sorteo->convenio_id  = $convenio->id;
            $sorteo->pais         = $convenio->paise_id;
        }else{
            $sorteo->convenio     = $request->nombre;
            $sorteo->llave        = $request->llave;
            $sorteo->pais         = 1;
        }

        $sorteo->fecha_inicio = $fecha_inicio;
        $sorteo->fecha_fin    = $fecha_fin;
        $sorteo->flag         = 0;
        $sorteo->tipo_sorteo     = $request->tipo_sorteo;
        $sorteo->created_at = Carbon::now();
        $sorteo->user_id    = Auth::user()->id;

        if ($sorteo->save()) {
            $data['success'] = true;
        }

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sorteo  $sorteo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $sorteo    = Sorteo::findOrFail($id);
        $registros = SorteoConvenio::where('empresa', $sorteo->convenio)->whereBetween('created', [$sorteo->fecha_inicio, $sorteo->fecha_fin])->get();

        return view('admin.sorteos.show', compact('registros', 'sorteo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sorteo  $sorteo
     * @return \Illuminate\Http\Response
     */
    public function edit(Sorteo $sorteo)
    {
        $data['view'] = view('admin.sorteos.edit', compact('sorteo'))->render();
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sorteo  $sorteo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sorteo $sorteo)
    {
        $data['success'] = false;
        $sorteo->fecha_inicio   = $request->fecha_inicio_update;
        $sorteo->fecha_fin      = $request->fecha_fin_update;
        $sorteo->flag           = isset($request->normal)?1:0;
        if($sorteo->save()){
            $data['success'] = true;
        }
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sorteo  $sorteo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sorteo $sorteo)
    {
        //
    }

    /**
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2022-05-30
     * Descripcion: Lista todos los sorteos registrados en BD
     * @param string $value [description]
     */
    public function listarSorteos($user_id = null)
    {
        // dd($user_id);
        $res = new Sorteo;

        if (Auth::user()->role != 'admin') {
            $sorteos = $res->where('user_id', $user_id)->orderBy('id', 'DESC')->get();
        } else {
            $sorteos = $res->orderBy('id', 'DESC')->get();
        }

        $data     = array();
        $i        = 1;
        $btn      = '';
        $btnPagos = '';

        foreach ($sorteos as $sorteo) {

            $registros = SorteoConvenio::where('empresa', $sorteo->convenio)->whereBetween('created', [$sorteo->fecha_inicio, $sorteo->fecha_fin])->count();

            $btn = '<div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Opciones
                        </button>
                        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">
                            <a class="dropdown-item" href="' . route('sorteos.edit', $sorteo->id) . '" id="btnEditar">Editar</a>
                            <a class="dropdown-item" href="' . route('sorteos.show', $sorteo->id) . '">Ver registros</a>
                            <a class="dropdown-item" href="' . route('sorteos.download', $sorteo->id) . '">Descargar registros</a>
                        </div>
                    </div>';
            $data[] = array(
                "0" => $sorteo->id,
                // "1" => '<a href="' . route('users.show', $sorteo->cliente->id) . '">' . $sorteo->cliente->fullName . '</a>',
                "1" => $sorteo->convenio,
                "2" => '<a href="' . env('FRONTEND_URL') . 'sorteo/' . $sorteo->llave . '" target="_blank">' . $sorteo->llave . '</a>',
                "3" => $sorteo->fecha_inicio,
                "4" => $sorteo->fecha_fin,
                "5" => '<label class="label label-' . $sorteo->estatus()['color'] . '">' . $sorteo->estatus()['estatus'] . '</label>',
                "6" => $btn,
                "7" => '<label class="label label-rounded label-success">' . $registros . '</label>',
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

    public function buscarConvenio(Request $request)
    {
        $data = Convenio::select("empresa_nombre", "id", 'llave')
            ->where('empresa_nombre', 'LIKE', '%' . $request->empresa_nombre . '%')
            ->get();

        return response()->json($data);
    }

    public function download($id)
    {
        $sorteo    = Sorteo::findOrFail($id);
        $registros = SorteoConvenio::where('empresa', $sorteo->convenio)->whereBetween('created', [$sorteo->fecha_inicio, $sorteo->fecha_fin])->get();
        return Excel::download(new SorteoConvenioExport($registros), 'Sorteo-' . $sorteo->convenio . '.xlsx');
    }


    public function showMedia($id)
    {
        $registro = SorteoConvenio::findOrFail($id);
        $data['success'] = true;
        $data['view'] = view('admin.sorteos.show_media', compact('registro'))->render();

        return response()->json($data);
    }
}
