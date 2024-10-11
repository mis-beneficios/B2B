<?php

namespace App\Http\Controllers;

use App\Concal;
use App\Convenio;
use App\Helpers\LogHelper;
use App\User;
use Auth;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;

class ConcalController extends Controller
{

    public $fecha = '';
    public $log;
    public function __construct()
    {
        $this->middleware('auth');
        $this->fecha = Carbon::now();
        $this->log   = new LogHelper;
    }

    /**
     * Validacion de formulario para crear y editar seguimiento de empresa
     * Autor: Diego Enrique Sanchez
     * Creado: 2022-03-14
     * @param  Request $request
     * @return validacion
     */
    public function validar_form(Request $request, $method = 'POST', $concal_id = null)
    {
        $validator = \Validator::make($request->all(), [
            'paise_id'          => 'required',
            'estatus'           => 'required',
            'estado'            => 'required',
            'empresa'           => ($method == 'POST') ? 'required | unique:concals' : 'required | unique:concals,empresa,' . $concal_id,
            'telefonos'         => 'required',
            'contacto'          => 'required',
            'email'             => 'required',
            // 'observaciones'     => 'required',
            'no_empleados'      => 'required',
            'siguiente_llamada' => 'required',
            'pagina_web'        => 'required',
            // 'calificacion'        => 'required',
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
        $this->authorize('viewAny', Concal::class);
        return view('admin.concals.index');
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
        $data['success'] = false;
        $validate = $this->validar_form($request);
        if ($validate->fails()) {
            return response()->json(['success' => false, 'errors' => $validate->errors()]);
        }

        $concal                  = new Concal;
        $concal->user_id         = Auth::id();
        $concal->username        = Auth::user()->username;
        $concal->paise_id        = $request->paise_id;
        $concal->estatus         = $request->estatus;
        $concal->estado          = $request->estado;
        $concal->created         = $this->fecha;
        $concal->modified        = $this->fecha;
        $concal->empresa         = $request->empresa;
        $concal->telefonos       = $request->telefonos;
        $concal->contacto        = $request->contacto;
        $concal->puesto_contacto = $request->puesto_contacto;
        $concal->email           = $request->email;
        // $concal->observaciones       = $request->observaciones;
        $concal->no_empleados        = $request->no_empleados;
        $concal->primer_llamada      = $this->fecha->format('Y-m-d');
        $concal->siguiente_llamada   = $request->siguiente_llamada;
        $concal->pagina_web          = $request->pagina_web;
        $concal->calificacion        = $request->calificacion;
        $concal->asistente           = $request->asistente;
        $concal->asistente_email     = $request->asistente_email;
        $concal->asistenten_telefono = $request->asistenten_telefono;
        $concal->conmutador          = $request->conmutador;

        $concal->giro           = $request->giro;
        $concal->categoria      = $request->categoria;
        $concal->sucursales     = $request->sucursales;
        $concal->sucursal_lugar = $request->sucursal_lugar;
        $concal->corporativo    = $request->corporativo;
        $concal->autoriza_logo  = $request->autoriza_logo;
        $concal->metodo_pago    = $request->metodo_pago;
        $concal->estrategia     = $request->estrategia;
        $concal->redes          = $request->redes;

        if ($concal->save()) {
            $data['success']  = true;
            $data['concal']   = $concal;
            $data['convenio'] = false;
        }

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Concal  $concal
     * @return \Illuminate\Http\Response
     */
    public function show(Concal $concal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Concal  $concal
     * @return \Illuminate\Http\Response
     */
    public function edit(Concal $concal)
    {
        return view('admin.concals.edit', compact('concal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Concal  $concal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $concal_id)
    {

        $method = $request->method();

        $validate = $this->validar_form($request, $method, $concal_id);

        if ($validate->fails()) {
            return response()->json(['success' => false, 'errors' => $validate->errors()]);
        }

        try {

            $concal = Concal::where('id', $concal_id)->first();

            //Convertimos el objeto a array para pasarlos como datos temporales y validar el cambio de informacion
            $temporal = $concal->toArray();

            $concal->paise_id = $request->paise_id;
            $concal->estatus  = $request->estatus;
            $concal->estado   = $request->estado;

            $concal->empresa         = $request->empresa;
            $concal->telefonos       = $request->telefonos;
            $concal->contacto        = $request->contacto;
            $concal->puesto_contacto = $request->puesto_contacto;
            $concal->email           = $request->email;
            $concal->observaciones   = $request->observaciones;
            $concal->no_empleados    = $request->no_empleados;
            if ($concal->primer_llamada != null) {
                $concal->primer_llamada = $this->fecha->format('Y-m-d');
            }

            if ($concal->ultima_llamada != null) {
                $concal->ultima_llamada = $this->fecha->format('Y-m-d');
            }

            $concal->siguiente_llamada   = $request->siguiente_llamada;
            $concal->pagina_web          = $request->pagina_web;
            $concal->calificacion        = $request->calificacion;
            $concal->asistente           = $request->asistente;
            $concal->asistente_email     = $request->asistente_email;
            $concal->asistenten_telefono = $request->asistenten_telefono;
            $concal->conmutador          = $request->conmutador;
            $concal->nextel              = $request->nextel;
            $concal->corporativo         = $request->corporativo;

            $concal->giro           = $request->giro;
            $concal->categoria      = $request->categoria;
            $concal->sucursales     = $request->sucursales;
            $concal->sucursal_lugar = $request->sucursal_lugar;
            $concal->corporativo    = $request->corporativo;
            $concal->autoriza_logo  = $request->autoriza_logo;
            $concal->metodo_pago    = $request->metodo_pago;
            $concal->estrategia     = $request->estrategia;
            $concal->redes          = $request->redes;

            if ($request->create_convenio == 1) {
                $res['convenio'] = $this->crear_convenio($concal);
                // dd($res);
            } else {
                $res['convenio'] = false;
            }

            if ($concal->save()) {
                if (array_diff($concal->getChanges(), $temporal)) {
                    $log = $this->log->concal_log(Auth::user(), $concal->getChanges(), $temporal, $concal);
                }
                $res['success'] = true;
            }

        } catch (Exception $e) {
            $res['errors'] = $e->getMessage();
        }

        // dd($res);
        return response()->json($res);
    }

    public function crear_convenio($data)
    {
        $convenio_res = Convenio::where('empresa_nombre', 'like', "%" . $data->empresa . "%")->orWhere('concal_id', $data->id)->first(['empresa_nombre', 'concal_id', 'user_id', 'id']);

        if ($convenio_res != null) {
            if ($convenio_res->concal_id == null || $convenio_res->concal_id == 0) {
                $convenio_res->concal_id = $data->id;
                $convenio_res->save();
                // $res = true;
                // dd($convenio_res);
                $res = 'Se ha asociado el seguimiento al convenio localizado como:  <a href="' . route('convenios.show', $convenio_res->id) . '" class="btn btn-link"><i class="fas fa-file-pdf"></i> ' . $convenio_res->empresa_nombre . '</a>';
            } else {
                $res = false;
            }
            // dd($data, $convenio_res, $res);
        } else {

            try {
                $key  = explode(' ', $data->empresa);
                $text = '';

                $llave = preg_replace('([^A-Za-z])', '', $key);

                if (count($llave) > 1) {
                    for ($i = 0; $i < count($llave); $i++) {
                        $text .= substr($llave[$i], 0, 2);
                    }
                } else {
                    $text = $llave[0];
                }

                $convenio                         = new Convenio;
                $convenio->user_id                = $data->user_id;
                $convenio->llave                  = 'mx' . strtolower($text);
                $convenio->empresa_nombre         = $data->empresa;
                $convenio->welcome                = $data->empresa;
                $convenio->bienvenida_convenio    = '';
                $convenio->created                = $this->fecha->format('Y-m-d');
                $convenio->modified               = $this->fecha->format('Y-m-d');
                $convenio->activo_hasta           = env('EST_VIGENCIA');
                $convenio->disponible             = 1;
                $convenio->nomina                 = 0;
                $convenio->contrato               = '';
                $convenio->paise_id               = 1;
                $convenio->contrato_nomina        = '';
                $convenio->convenio_maestro       = 0;
                $convenio->convenio_bancario      = 1;
                $convenio->terminos_y_condiciones = '';
                $convenio->comision_conveniador   = env('COM_CONVENIO', 100.00);
                $convenio->video                  = null;
                $convenio->campana_inicio         = $this->fecha->subDays(10);
                $convenio->campana_fin            = $this->fecha->subDays(10);
                $convenio->campana_paquetes       = 0;
                $convenio->logo                   = null;
                $convenio->url                    = null;
                $convenio->grupo                  = null;
                $convenio->pago                   = ($data->metodo_pago != null) ? $data->metodo_pago : 'Banca';
                $convenio->visitas_web            = null;
                $convenio->school                 = null;
                $convenio->img                    = '';
                $convenio->img_bienvenida         = null;
                $convenio->leyenda_escuelas       = null;
                $convenio->titulo_escuelas        = null;
                $convenio->salesgroup_id          = null;
                $convenio->concal_id              = $data->id;
                $convenio->fecha_cierre           = date('Y-m-d');

                if ($convenio->save()) {
                    $res = 'Se ha creado una nueva liga <a href="' . route('convenios.show', $convenio->id) . '" class="btn btn-link"><i class="fas fa-file-pdf"></i> Ver</a>';
                }
            } catch (\Exception $e) {
                $res = (strpos($e->getMessage(), 'Duplicate entry') ? 'El registor ya existe, comprueba el listado de convenios' : $e->getMessage());
            }
        }
        return $res;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Concal  $concal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Concal $concal)
    {
        //
    }

    public function get_concals_day($user_id = null)
    {
        $concals = Concal::where([
            'user_id'  => Auth::id(),
            'paise_id' => 1,
        ])
            ->where('siguiente_llamada', '<=', date('Y-m-d'))
            ->whereNotIn('estatus', ['rechazada', 'cerrado', 'ellos_llaman'])
            ->orderBy('siguiente_llamada', 'DESC')
            ->get();

        $data = array();
        $i    = 1;
        $btn  = '';
        $info = '';
        $body = '';

        foreach ($concals as $concal) {
            $info = ($concal->log != null) ? '<button type="button" class="btn btn-dark btn-xs mr-1 btnLogConcal" id="btnLogConcal" data-id="' . $concal->id . '"><i class="fas fa-info"></i></button>' : '';

            $body = '<div class="concalslist mr-5"><strong><span style="font-size:12px" class="label label-info mr-5 pr-5">' . $concal->siguiente_llamada . '</span><small class="">' . $info . '<a target="_blank" href="' . route('concals.edit', $concal->id) . '" id="btnEditConcal_" data-id="' . $concal->id . '" data-type="editar" class="btn btn-dark btn-xs btnEmpresa_"><i class="fas fa-edit"></i></a></small><strong><h4 class="text-uppercase mt-2 text-wrap">' . $concal->empresa . '</h4>
            <div class="span_blocks text-wrap"><span class="contact text-wrap"><span class="fas fa-user "></span> ' . $concal->contacto . '</span></br><span class="email text-wrap"><span class="fa fa-envelope-open"></span> ' . $concal->email . '</span></br><span class="telefono text-wrap"><span class="fas fa-mobile-phone "></span> ' . $concal->telefonos . '</span><div alt="" class="observaciones clic-to-full nota"></div></div></div>';

            $data[] = array(
                "1" => $body,
            );

            $btn  = '';
            $info = '';
            $body = '';

        }
        $results = array(
            "sEcho"                => 1,
            "iTotalRecords"        => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData"               => $data,
        );

        return response()->json($results);
    }

    public function get_calendar_concals(Request $request)
    {
        // dd($request->all());

        $concals = Concal::with('user')->where(['paise_id' => 1, "isDelete" => 0]);
        // ->select('empresa', 'pagina_web', 'no_empleados', 'contacto', 'email', 'telefonos', 'siguiente_llamada', 'ultima_llamada', 'primer_llamada', 'estatus', 'estado', 'id');

        if ($request->nombre != null) {
            $concals->where('empresa', 'LIKE', "%{$request->nombre}%");
        }
        if ($request->inicio_rango != null && $request->fin_rango != null) {
            $concals->whereBetween('siguiente_llamada', [$request->inicio_rango, $request->fin_rango]);
        }
        if ($request->estatus_concal != null) {
            $concals->whereIn('estatus', [$request->estatus_concal]);
        }

        if ($request->mostrar == 'mios') {
            $concals->where('user_id', $request->user_id);
        }

        // $concals->get();

        return Datatables::eloquent($concals)
            ->addColumn('empresa', function ($concals) {
                return "<strong>" . $concals->empresa . "<br/><span style='font-size:12px'><a href='javascript():;'>" . $concals->pagina_web . "</a></span><br/><small class='text-info' style='font-size: 10px'><strong>" . $concals->no_empleados . " Empleados</strong></small></strong>";
            })
            ->editColumn('contacto', function ($concals) {
                return "<strong>" . $concals->contacto . " <br/><span style='font-size:12px'>" . $concals->email . "</span><br/><small class='text-info' style='font-size: 10px'><strong>" . $concals->telefonos . "</strong></small></strong>";
            })
            ->addColumn('primer_llamada', function ($concals) {
                return "<strong>" . $concals->siguiente_llamada . " <br/><span style='font-size:12px'>" . $concals->ultima_llamada . "</span><br/><small class='text-info' style='font-size: 10px'><strong>" . $concals->primer_llamada . " </strong></small></strong>";
            })
            ->addColumn('conveniador', function ($concals) {
                return "<strong>" . $concals->user->fullName . "<br/><span style='font-size:12px'>" . $concals->estado . "</span></strong>";
            })
            ->addColumn('estatus', function ($concals) {
                return "<strong class='label' style='background-color:" . $concals->color_estatus() . ";'>" . $concals->estatus . "<br/><span style='font-size:12px'></span></strong>";
            })

            ->addColumn('action', function ($concals) {
                $btn = '';

                $btn .= ($concals->log != null) ? '<button class="btn btn-dark btn-xs m-1 btnConcal btnLogConcal" data-type="info" id="" type="button" data-id="' . $concals->id . '"><i class="fas fa-info"></i></button>' : '';

                // $btn .= '<button class="btn btn-info btn-xs m-1 btnConcal btnEmpresa"  data-type="editar" id="" type="button" data-id="' . $concals->id . '"><i class="fas fa-edit"></i></button>';

                $btn .= '<a href="' . route('concals.edit', $concals->id) . '" target="_blank" class="btn btn-success btn-xs m-1"  data-type="show" id="" type="button" data-id="' . $concals->id . '"><i class="fas fa-eye"></i></a>';

                $btn .= (Auth::user()->can('reasignar', $concals)) ? '<button class="btn btn-warning btn-xs m-1 btnConcal" data-type="reasignar" id="btnAsignar" type="button" data-concal_id="' . $concals->id . '" data-url="' . route('concals.form_reasignar', $concals->id) . '"><i class="fas fa-user"></i></button>' : '';

                // if ($concals->convenio != null) {
                //     $btn .= '<a class="btn btn-success btn-xs m-1 text-white" href="' . route('convenios.show', $concals->convenio->id) . '"><i class="fas fa-file-pdf"></i></a>';
                // } else {
                //     $btn .= '';
                // }
                // $btn .= (Auth::user()->can('convenio', $concals)) ?: '';
                return $btn;
            })
            ->rawColumns(['empresa', 'contacto', 'primer_llamada', 'conveniador', 'estatus', 'action'])
            ->make(true);
    }

    public function get_log($concal_id)
    {
        $concal = Concal::findOrFail($concal_id);

        $data['success'] = true;
        $data['log']     = $concal->logConcal;

        return response()->json($data);
    }

    public function modal_form($type, $concal_id = null)
    {
        $data['success'] = true;
        $method          = 'POST';
        $url             = route('concals.store');
        $data['view']    = view('admin.concals.elementos.form', compact('url', 'method'))->render();

        if ($type == 'editar') {
            $concal       = Concal::findOrFail($concal_id);
            $method       = 'PUT';
            $url          = route('concals.update', $concal->id);
            $data['view'] = view('admin.concals.elementos.form_edit', compact('url', 'method', 'concal'))->render();
        }

        return response()->json($data);
    }

    public function form_concals($concal_id)
    {
        $concal        = Concal::findOrFail($concal_id);
        $conveniadores = User::where('role', 'conveniant')->get();

        $data['view'] = view('admin.concals.elementos.form_reasignar_concal', compact('concal', 'conveniadores'))->render();

        return response()->json($data);
    }

    public function asignar_concals(Request $request, $concal_id)
    {

        try {
            $data['success'] = false;
            $concal          = Concal::findOrFail($concal_id);
            $temporal        = $concal->toArray();
            $concal->user_id = $request->user_id;
            if ($concal->save()) {
                if (array_diff($concal->getChanges(), $temporal)) {
                    $log = $this->log->concal_log(Auth::user(), $concal->getChanges(), $temporal, $concal);
                }
                $data['success'] = true;
            }
        } catch (Exception $e) {
            $data['success'] = false;
        }

        return response()->json($data);
    }

}
