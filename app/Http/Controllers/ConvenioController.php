<?php

namespace App\Http\Controllers;

use App\Convenio;
// use App\Http\Requests\UpdateConvenioRequest;
use App\User;
use Auth;
// use DataTables;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Storage; 


class ConvenioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Validacion de formulario para crear y editar convenio
     * Autor: Diego Enrique Sanchez
     * Creado: 2022-10-26
     * @param  Request $request
     * @return validacion
     */
    public function validar_form(Request $request, $method = 'POST', $convenio_id = null)
    {
        $validator = \Validator::make($request->all(), [
            'empresa_nombre'       => 'required',
            // 'bienvenida_convenio'  => 'required',
            // 'estatus'              => 'required',
            'llave'                => 'required | unique:convenios,llave,' . $convenio_id,
            'comision_conveniador' => 'required',
            // 'terminos_y_condiciones' => 'required',
            // 'asistente'           => 'required',
            // 'asistente_email'     => 'required',
            // 'asistenten_telefono' => 'required',
            // 'conmutador'          => 'required',
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

        $this->authorize('viewAny', Convenio::class);
        $conveniadores = User::whereRole('conveniant')->get();
        return view('admin.convenios.index', compact('conveniadores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Convenio::class);
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
     * @param  \App\Convenio  $convenio
     * @return \Illuminate\Http\Response
     */
    public function show(Convenio $convenio)
    {
        if (Auth::user()->can('view', $convenio)) {
            return view('admin.convenios.show', compact('convenio'));
        }
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Convenio  $convenio
     * @return \Illuminate\Http\Response
     */
    public function edit(Convenio $convenio)
    {
        if (Auth::user()->can('update', $convenio)) {
            return view('admin.convenios.edit', compact('convenio'));
        }
        abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Convenio  $convenio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $convenio_id)
    {

        // dd($request->all());
        try {
            $method   = $request->method();
            $validate = $this->validar_form($request, $method, $convenio_id);
            if ($validate->fails()) {
                return response()->json(['success' => false, 'errors' => $validate->errors()]);
            }
            $convenio = Convenio::findOrFail($convenio_id);

            $data['success'] = false;

            $convenio->empresa_nombre      = $request->empresa_nombre;
            $convenio->llave               = $request->llave;
            $convenio->welcome             = strtoupper($convenio->empresa_nombre);
            $convenio->bienvenida_convenio = $request->bienvenida_convenio;

            $convenio->modified     = Carbon::now()->format('Y-m-d');
            $convenio->activo_hasta = $request->activo_hasta;
            $convenio->disponible   = $request->val_disponible;
            $convenio->nomina       = $request->val_nomina;

            $convenio->convenio_bancario      = $request->val_convenio_banc;
            $convenio->terminos_y_condiciones = $request->terminos_y_condiciones;
            $convenio->comision_conveniador   = $request->comision_conveniador;

            $convenio->campana_inicio   = $request->campana_inicio;
            $convenio->campana_fin      = $request->campana_fin;
            $convenio->campana_paquetes = $request->campana_paquetes;
            $convenio->url              = $request->url;

            if ($convenio->save()) {
                $data['success'] = true;
                $data['url']     = route('convenios.show', $convenio->id);
            }
        } catch (Exception $e) {

        }

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Convenio  $convenio
     * @return \Illuminate\Http\Response
     */
    public function cargar_imagen(Request $request)
    {

     
        $data['success'] = false;
        $convenio        = Convenio::findOrFail($request->convenio_id);

        if ($file = $request->file('logo')) {
            $imagen = $request->file('logo');
            $nombreImagen = 'files/empresas/'.$convenio->llave.'/'. uniqid() . '_' . str_replace(' ', '-', $imagen->getClientOriginalName());
            Storage::disk('s3')->put($nombreImagen, file_get_contents($imagen));
            $convenio->logo = $nombreImagen;            
        } else if ($file = $request->file('img_bienvenida')) {
            $imagen = $request->file('img_bienvenida');
            $nombreImagen = 'files/empresas/'.$convenio->llave.'/'. uniqid() . '_' . str_replace(' ', '-', $imagen->getClientOriginalName());
            Storage::disk('s3')->put($nombreImagen, file_get_contents($imagen));
            $convenio->img_bienvenida = $nombreImagen;

        } else if ($file = $request->file('convenio_file')) {
            $imagen = $request->file('convenio_file');
            $nombreImagen = 'files/empresas/'.$convenio->llave.'/'. uniqid() . '_' . str_replace(' ', '-', $imagen->getClientOriginalName());
            Storage::disk('s3')->put($nombreImagen, file_get_contents($imagen));
            $convenio->convenio_file = $nombreImagen;
        }

        if ($convenio->save()) {
            $data['success'] = true;
        }

        return $data;




        // $data['success'] = false;
        // $convenio        = Convenio::findOrFail($request->convenio_id);

        // if ($file = $request->file('logo')) {
        //     // dd(file_get_contents($request->file('logo')));
        //     // 
        //     Storage::disk('s3')->put('images/empresa/logos', file_get_contents($request->file('logo')));
        //     // $convenio->logo = $convenio->llave;            

        //     //Correcto
        //     // $destinationPath = public_path('/images/empresas/');
        //     // $profileImage    = trim(time() . trim($file->getClientOriginalName()));
        //     // // $file->move($destinationPath, $profileImage);
        //     // $convenio->logo = $profileImage;

        // } else if ($file = $request->file('img_bienvenida')) {
        //     $destinationPath = public_path('/images/empresas/');
        //     $bienvenida      = trim(time() . trim($file->getClientOriginalName()));
        //     // $file->move($destinationPath, $bienvenida);
        //     $convenio->img_bienvenida = $bienvenida;

        // } else if ($file = $request->file('convenio_file')) {
        //     $destinationPath = public_path('/files/convenios/');
        //     $convenio_pdf    = trim(time() . trim($file->getClientOriginalName()));
        //     // $file->move($destinationPath, $convenio_pdf);
        //     $convenio->convenio_file = $convenio_pdf;
        // }

        // if ($convenio->save()) {
        //     $data['success'] = true;
        // }

        // return $data;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Convenio  $convenio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Convenio $convenio)
    {
        //
    }

    /**
     * Autor: ISW. Diego Sanchez
     * Creado: 2022-10-09
     * Listado de convenios server side para la carga mayor a 1k de registros evitando saturacion de carga de datos
     * @param  [type] $user_id
     * @return [type] datatable
     */
    public function get_convenios(Request $request)
    {
        // dd($request->all());
        $convenios = Convenio::with('user')->where('paise_id', 1)
        // ->where('disponible', 1)
        ->select('id', 'paise_id', 'llave', 'empresa_nombre', 'user_id','disponible');

        // dd($convenios->limit(10)->get());
        if ($request->mostrar == 'mios') {
            $convenios->where('user_id', $request->user_id);
        }else if($request->mostrar != 'todos'){
            $convenios->where('user_id', $request->mostrar);
        }

        return DataTables::eloquent($convenios)
            ->editColumn('id', function ($convenios) {
                return '<a href="'.route('convenios.show', $convenios->id).'" class="btn btn-link">'.ucwords($convenios->id).'</a>';
            })
            ->addColumn('estatus', function ($convenios) {
               if ($convenios->disponible == 1) {
                   $dis = 'btn-info';
                   $text = 'Activo';
               }else{
                   $dis = 'btn-danger';
                   $text = 'Inactivo';
               }
                return '<button id="estatusConvenio" data-url="'. route('convenios.changeStatus', [$convenios->id, $convenios->disponible]).'" data-estatus="'.$convenios->disponible.'" class="btn '.$dis.' btn-sm">'.$text.' </button>';


            })
            ->addColumn('liga', function ($convenios) {
                return '<a href="' . config('app.url_front') . 'productos/' . $convenios->llave . '" target="_blank">' . config('app.url_front') . 'productos/' . $convenios->llave . '</a>';
            })
            ->addColumn('contratos_vendidos', function ($convenios) {
                if (Auth::user()->can('view', $convenios)) {
                    return '<a class="label label-info" href="' . route('convenios.show', $convenios->id) . '">' . count($convenios->contratos) . '</a>';
                } else {
                    return '<label class="label label-info">' . count($convenios->contratos) . '</label>';
                }
            })
            ->addColumn('conveniador', function ($convenios) {
                return ($convenios->user) ? $convenios->user->fullName : 'S/R';
            })
            ->addColumn('actions', function ($convenios) {
                
                $btn = '';

                if (Auth::user()->can('view', $convenios)) {
                    $btn .= '<a href="' . route('convenios.show', $convenios->id) . '" data-id="' . $convenios->id . '"  id="btnVer" class="dropdown-item"><i class="fa fa-eye"></i> Ver</a>';
                }
                if (Auth::user()->can('update', $convenios)) {
                    $btn .= '<a href="' . route('convenios.edit', $convenios->id) . '" data-id="' . $convenios->id . '"  id="btnEditar" class="dropdown-item"><i class="fa fa-edit"></i> Editar</a>';
                }
                if (Auth::user()->can('reasignar', $convenios)) {
                    $btn .= '<a href="javascript:void(0)" data-url="' . route('convenios.form_reasignar', $convenios->id) . '" data-convenio_id="' . $convenios->id . '" class="dropdown-item" id="btnAsignar"><i class="fas fa-users"></i> Reasignar</a>';
                }
                if (Auth::user()->can('delete', $convenios)) {
                    $btn .= '<a href="javascript:void(0)" value="' . $convenios->id . '" class="dropdown-item" id="btnEliminar"><i class="fas fa-trash-alt"></i> Eliminar</a>';
                }


                 $btn = '<div class="btn-group">
                            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Opciones
                            </button>
                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">
                               '.$btn.'
                            </div>
                        </div>';


                return $btn;
            })
            ->rawColumns(['id', 'estatus', 'liga', 'convenio', 'contratos_vendidos', 'actions','empresa_nombre'])
            ->make(true);
    }

    public function form_convenios($convenio_id)
    {
        $convenio      = Convenio::findOrFail($convenio_id);
        $conveniadores = User::where('role', 'conveniant')->get();

        $data['view'] = view('admin.convenios.elementos.form_reasignar_convenio', compact('convenio', 'conveniadores'))->render();

        return response()->json($data);
    }

    public function asignar_convenio(Request $request, $convenio_id)
    {

        try {
            $data['success']   = false;
            $convenio          = Convenio::findOrFail($convenio_id);
            $convenio->user_id = $request->user_id;
            if ($convenio->save()) {
                $data['success'] = true;
            }
        } catch (Exception $e) {
            $data['success'] = false;
        }

        return response()->json($data);
    }



    public function list_convenios_ajax()
    {
        $data['convenios'] = Convenio::where('paise_id', env('APP_PAIS_ID', 1))->get(['id', 'empresa_nombre']);

        return response()->json($data);
    }


    public function changeStatus($id, $estatus)
    {

        $convenio = Convenio::findOrFail($id);
        $data['success'] = false;
        
        try {
            $convenio->disponible = ($estatus == 0) ? 1 : 0;
            $convenio->save();
            $data['success'] = true; 
        } catch (\Exception $e) {
            $data['errors'] = $e->getMessage();
        }


        return response()->json($data);
    }
}
