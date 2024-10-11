<?php

namespace App\Http\Controllers;

use App\Estancia;
// use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EstanciaController extends Controller
{




        /**
     * Validacion de formulario para crear usuario
     * Autor: Diego Enrique Sanchez
     * Creado: 2021-08-09
     * @param  Request $request
     * @param  Int  $id  validar datos del usuario existente
     * @return validacion
     */
    public function validar_form(Request $request, $method = 'POST', $user = null)
    {
        $validator = \Validator::make($request->all(), [
            'title'             => 'required | max:100',
            'precio'            => 'required | numeric | min:0',
            'divisa'            => 'required',
            'descuento'         => ($request->descuento) ? 'required' : '', //| confirmed
            'noches'            => 'required | numeric',
            'adultos'           => 'required | numeric',
            'ninos'             => 'required | numeric',
            'edad_max_ninos'    => ($request->edad_max_ninos) ? 'required | numeric' : '',
            'precio_por_nino'   => ($request->precio_por_nino) ? 'required | numeric' : '',
            'precio_por_adulto' => ($request->precio_por_adulto) ? 'required | numeric' : '',
            'cuotas'            => 'required | numeric',
            'tipo'              => 'required',
            'estancia_paise_id' => 'required',
            'estancia_especial' => ($request->estancia_especial) ? 'required' : '',
            'enganche_especial' => ($request->estancia_especial) ? 'required' : '',
            // 'habilitada'        => 'required',
            // 'solosistema'       => 'required',
            'descripcion'       => 'required',
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
        // dd('entra al metodo');

        $this->authorize('viewAny', Estancia::class);
        return view('admin.estancias.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('viewAny', Estancia::class);
        $estancia = false;
        return view('admin.estancias.create', compact('estancia'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $data['success'] = false;
        $validate = $this->validar_form($request);
        if ($validate->fails()) {
            return response()->json(['success' => false, 'errors' => $validate->errors()]);
        }

        $estancia = new Estancia;

        $estancia->solosistema      = isset($request->solosistema) ? 1 : 0;
        $estancia->convenio_id      = isset($request->convenio_id) ? $request->convenio_id : 0;
        $estancia->title            = $request->title;
        $estancia->precio           = $request->precio;
        $estancia->divisa           = $request->divisa;
        $estancia->descuento        = $request->descuento;
        $estancia->noches           = $request->noches;
        $estancia->adultos          = $request->adultos;
        $estancia->ninos            = $request->ninos;
        $estancia->edad_max_ninos   = $request->edad_max_ninos;
        $estancia->precio_por_nino  = $request->precio_por_nino;
        $estancia->precio_por_adulto = $request->precio_por_adulto;
        $estancia->cuotas           = $request->cuotas;
        $estancia->tipo             = $request->tipo;
        $estancia->estancia_paise_id = $request->estancia_paise_id;
        $estancia->estancia_especial = $request->estancia_especial;
        $estancia->enganche_especial = $request->enganche_especial;
        $estancia->habilitada       = isset($request->habilitada) ? 1 : 0;
        $estancia->descripcion      = $request->descripcion;
        
        // Imagenes
        $estancia->imagen_de_reemplazo  = $request->imagen_de_reemplazo;
        $estancia->slide                = $request->slide;
        $estancia->img_producto         = $request->img_producto;
        $estancia->img_descripcion      = $request->img_descripcion;
        $estancia->img_secundaria       = $request->img_secundaria;
        $estancia->img_opcional         = $request->img_opcional;
        $estancia->usd_mxp              = ($request->divisa == 'USD') ? 1 : 0;
        $estancia->caducidad            = config('app.vigencia');
        $estancia->descripcion_formal   = $request->descripcion_formal;


        if ($estancia->save()) {
            $data['success'] = true;
            $data['url']     = route('estancias.index');
        }
        
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Estancia  $estancia
     * @return \Illuminate\Http\Response
     */
    public function show(Estancia $estancia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Estancia  $estancia
     * @return \Illuminate\Http\Response
     */
    public function edit(Estancia $estancia)
    {
        $this->authorize('update', Estancia::class);
        return view('admin.estancias.edit', compact('estancia'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Estancia  $estancia
     * @return \Illuminate\Http\Response
     */
    public function clonar($id)
    {
        // $this->authorize('clonar', Estancia::class);
        $estancia = Estancia::findOrFail($id);
        // dd($estancia);
        $url = route('estancias.store');
        return view('admin.estancias.clonar', compact('estancia'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Estancia  $estancia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $estancia_id)
    {
        $this->authorize('update', Estancia::class);

        $data['success'] = false;
        $validate = $this->validar_form($request);
        if ($validate->fails()) {
            return response()->json(['success' => false, 'errors' => $validate->errors()]);
        }
        $estancia = Estancia::findOrFail($estancia_id);



        $estancia->solosistema      = isset($request->solosistema) ? 1 : 0;
        $estancia->convenio_id      = isset($request->convenio_id) ? $request->convenio_id : 0;
        // $estancia->invitacion_id    = $request->invitacion_id;
        $estancia->title            = $request->title;
        $estancia->precio           = $request->precio;
        $estancia->divisa           = $request->divisa;
        $estancia->descuento        = $request->descuento;
        $estancia->noches           = $request->noches;
        $estancia->adultos          = $request->adultos;
        $estancia->ninos            = $request->ninos;
        $estancia->edad_max_ninos   = $request->edad_max_ninos;
        $estancia->precio_por_nino  = $request->precio_por_nino;
        $estancia->precio_por_adulto = $request->precio_por_adulto;
        $estancia->cuotas           = $request->cuotas;
        $estancia->tipo             = $request->tipo;
        $estancia->estancia_paise_id = $request->estancia_paise_id;
        $estancia->estancia_especial = $request->estancia_especial;
        $estancia->enganche_especial = $request->enganche_especial;
        $estancia->habilitada       = isset($request->habilitada) ? 1 : 0;
        $estancia->descripcion      = $request->descripcion;
        
        // Imagenes
        $estancia->imagen_de_reemplazo = $request->imagen_de_reemplazo;
        $estancia->slide            = $request->slide;
        $estancia->img_producto     = $request->img_producto;
        $estancia->img_descripcion  = $request->img_descripcion;
        $estancia->img_secundaria   = $request->img_secundaria;
        $estancia->img_opcional     = $request->img_opcional;
        $estancia->usd_mxp          = ($request->divisa == 'USD') ? 1 : 0;
        $estancia->caducidad        = config('app.vigencia');


        
        if ($estancia->save()) {
            $data['success'] = true;
            $data['url']     = route('estancias.index');
        }
        
        return response()->json($data);


        // $estancia->descripcion_formal = $request->descripcion_formal;
        // $estancia->caducidad        = $request->caducidad;
        // $estancia->estancia_maestra = $request->estancia_maestra;
        // $estancia->master_key       = $request->master_key;
        // $estancia->calculo_por_venta = $request->calculo_por_venta;
        // $estancia->comunes_estancia_paise_id = $request->comunes_estancia_paise_id;
        // $estancia->temporada         = $request->temporada;
        // $estancia->hotel_name       = $request->hotel_name;
        // $estancia->est_especial     = $request->est_especial;
        // $estancia->destino_id       = $request->destino_id;
        // $estancia->slug             = $request->slug;


        // dd($request->all());
    }

    /**
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-11-26
     * Actualizacion del contrato de la estancia seleccionada
     * @param  Request  $request
     * @param  Estancia $estancia
     * @return json response
     */
    public function update_contrato($id, Request $request)
    {
        $data['success']              = false;
        $estancia                     = Estancia::findOrFail($id);
        $estancia->descripcion_formal = $request->descripcion_formal;
        if ($estancia->save()) {
            $data['success'] = true;
        }

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Estancia  $estancia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Estancia $estancia)
    {
        //
    }

    public function get_estancia($id)
    {
        $estancia = Estancia::findOrFail($id);
        return response()->json(['success' => true, 'estancia' => $estancia]);
    }

    public function listar_estancias()
    {
        $estancias = Estancia::where('estancia_paise_id', env('APP_PAIS_ID'))->whereYear('caducidad', '>=', (date('Y') - 4))->select(['id', 'title', 'precio', 'habilitada', 'noches', 'cuotas', 'caducidad', 'divisa'])->orderBy('id', 'DESC');
        $data      = array();
        $i         = 1;
        $btn       = '';

        return DataTables::eloquent($estancias)
            ->editColumn('id', function ($estancias) {
                return ucwords($estancias->id);
            })

            ->editColumn('title', function ($estancias) {
                return $estancias->title;
            })
            ->editColumn('precio', function ($estancias) {
                return $estancias->divisa . ' ' . number_format($estancias->precio);
            })
            ->addColumn('estatus', function ($estancias) {
                $class      = ($estancias->habilitada == 1) ? 'btn-success' : 'btn-danger';
                $btnEstatus = '<button type="button" class="btn ' . $class . ' btn-xs btnHabilitada" data-url="' . route('estancias.activar', $estancias->id) . '" data-estatus="' . $estancias->habilitada . '">Inactiva</button>';
                return $btnEstatus;
            })
            ->editColumn('caducidad', function ($estancias) {
                return $estancias->caducidad;
            })
            ->editColumn('cuotas', function ($estancias) {
                return $estancias->cuotas;
            })
            ->editColumn('noches', function ($estancias) {
                return 'Noches: ' . $estancias->noches . ' | Adultos: ' . $estancias->adultos . ' | Niños: ' . $estancias->ninos;
            })
            ->addColumn('actions', function ($estancias) {
                $btn = '';
                $btn .= '<a href="'.route('estancias.clonar', $estancias->id).'" class="btn btn-dark btn-xs mr-1" value="' . $estancias->id . '" id="btnCopyEstancia" type="button"><i class="fas fa-copy"></i></a>';

                if (Auth::user()->can('update', $estancias)) {
                    $btn .= '<a class="btn btn-success btn-xs mr-1" href="' . route('estancias.edit', $estancias->id) . '" value="' . $estancias->id . '" id="btnEditarEstancia"><i class="fas fa-edit"></i></a>';
                }

                if (Auth::user()->can('delete', $estancias)) {
                    $btn .= '<button class="btn btn-danger btn-xs" value="' . $estancias->id . '" id="btnEliminarEstancia" type="button"><i class="fas fa-trash"></i></button>';
                }

                return $btn;
            })
            ->rawColumns(['id', 'title', 'precio', 'caducidad', 'noches', 'actions', 'estatus', 'cuotas'])
            ->make(true);

    }

    public function activar_estancia($id, Request $request)
    {
        $data['success']      = false;
        $estancia             = Estancia::findOrFail($id);
        $estancia->habilitada = ($request->estatus == '0') ? 1 : 0;

        if ($estancia->save()) {
            $data['success'] = true;
        }

        return response()->json($data);
    }

}
