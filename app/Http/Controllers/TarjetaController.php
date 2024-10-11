<?php

namespace App\Http\Controllers;

use App\Contrato;
use App\Reservacion;
use App\Tarjeta;
use Auth;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use App\Traits\LogTrait;
use App\Helpers\TarjetaHelper;
use PhpParser\Node\Stmt\TryCatch;

class TarjetaController extends Controller
{
    use LogTrait;

    public $numRegistros = 1;
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Autor:    Diego Enrique Sanchez
     * Creado:   2021-08-31
     * Accion:   Validacion del formulario de registro de tarjeta a cliente, validacion ajax
     * @param    $request
     * @return   response
     */
    public function validar_form_card(Request $request, $id = null)
    {

        $validator = \Validator::make($request->all(), [
            'titular'        => 'required | string | max:40',
            'numero_tarjeta' => ($request->tipo_cuenta == '03') ? 'required | numeric | digits:16' : 'required | numeric | digits:18',
            'tipo_card'      => ($request->tipo_cuenta == '03') ? 'required' : '',
            'banco'          => 'required',
            'tipo'           => ($request->tipo_cuenta == '03') ? 'required' : '',
            'vencimiento'    => ($request->tipo_cuenta == '03') ? 'required' : '',
            'cvv2'           => !isset($id) ? (($request->tipo_cuenta == '03') ? 'required' : ''): '',
            'tipo_cuenta'    => 'required',
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

        $this->authorize('viewAny', Tarjeta::class);
        return view('admin.tarjetas.index');
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
        $validate        = $this->validar_form_card($request);
        if ($validate->fails()) {
            return response()->json(['success' => false, 'errors' => $validate->errors()]);
        }

        // validar el numero de registros de la tarjeta
        $cardCount = Tarjeta::where('numero', $request->numero_tarjeta)->count();

        if (Auth::user()->role == 'sales' || Auth::user()->role == 'supervisor') {
            if ($cardCount >= $this->numRegistros) {
                return response()->json(['success' => false, 'message' => 'El número de la tarjeta ya ha sido registrada más de ' . $this->numRegistros . ' ocasiones']);
                exit();
            }
        }

        $vence = explode('/', $request->vencimiento);

        $tarjeta           = new Tarjeta;
        $tarjeta->user_id  = $request->user_id;
        $tarjeta->banco_id = $request->banco;
        $tarjeta->name     = $request->titular;
        $tarjeta->numero   = $request->numero_tarjeta;
        $tarjeta->banco    = $request->tipo_card;
    
        $tarjeta->mes = ($request->vencimiento) ? $vence[0] : date('m');
        $tarjeta->ano = ($request->vencimiento) ? $vence[1] : date('Y');

        $tarjeta->cvv2               = ($request->tipo_cuenta == '03') ? $request->cvv2 : '000';
        $tarjeta->tipo               = $request->tipo;
        $tarjeta->estatus            = 'Sin Verificar';
        $tarjeta->historico_de_pagos = 'al_corriente';
        $tarjeta->created            = Carbon::now();
        $tarjeta->tipocuenta         = $request->tipo_cuenta;

        $tarjeta->importado            = 0;
        $tarjeta->autorizo             = 1;
        $tarjeta->agreeterms           = 1;
        $tarjeta->firstpaymentdeducted = 0;

        $tarjeta->padre_id = (Auth::user()->admin_padre) ? Auth::user()->admin_padre->id : '';

        if ($tarjeta->save()) {
            $data['success'] = true;
        }

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tarjeta  $tarjeta
     * @return \Illuminate\Http\Response
     */
    public function show(Tarjeta $tarjeta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tarjeta  $tarjeta
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {                
            $tarjeta = Tarjeta::findOrFail($id);
            $data['success'] = true;
            $data['view'] = view('admin.tarjetas.elementos.from_edit', compact('tarjeta'))->render();

        } catch (\Exception $e) {
            $data['success'] = false;
            $data['errors'] = $e->getMessage();
        }
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tarjeta  $tarjeta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $tarjeta = Tarjeta::findOrFail($id);
            $temporal = $tarjeta->toArray();


            $data['success'] = false;
            $validate        = $this->validar_form_card($request, $id);
            if ($validate->fails()) {
                return response()->json(['success' => false, 'errors' => $validate->errors()]);
            }

            $vence = explode('/', $request->vencimiento);

            $tarjeta->estatus  = $request->estatus;
            $tarjeta->banco_id = $request->banco;
            $tarjeta->name     = $request->titular;
            $tarjeta->numero   = $request->numero_tarjeta;
            $tarjeta->banco    = $request->tipo_card;
        
            $tarjeta->mes = ($request->vencimiento) ? $vence[0] : date('m');
            $tarjeta->ano = ($request->vencimiento) ? $vence[1] : date('Y');

            if ($request->cvv2) {
                $tarjeta->cvv2               = ($request->tipo_cuenta == '03') ? $request->cvv2 : '000';
            }

            $tarjeta->tipo               = $request->tipo;
            $tarjeta->tipocuenta         = $request->tipo_cuenta;

            if ($tarjeta->save()) {
                $data['success'] = true;
                /**
                 * Creacion o edicion del historial de cambios al registro
                 * Cambiar o programar un observer para evitar la llamada al metodo y hacerlo automaticamente al ejecutar el evento update del modelo
                 */
                $this->create_log(Auth::user(), $tarjeta->getChanges(), $temporal, $tarjeta);
            }
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['catch'] = $e->getMessage();
        }

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tarjeta  $tarjeta
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data['success'] = false;
        $con             = [];
        $res             = [];
        $data['message'] = '';
        try{
            $tarjeta         = Tarjeta::findOrFail($id);
            $contratos       = Contrato::where('tarjeta_id', $id)->get();
            $reservaciones   = Reservacion::where('tarjeta_id', $id)->get();

            if (count($contratos) >= 1) {
                foreach ($contratos as $c) {
                    $con[] = $c->id;
                }
                TarjetaHelper::desvincularContratos($con);
            }
    
            if (count($reservaciones) >= 1) {
                foreach ($reservaciones as $r) {
                    $res[]= $r->id;
                }
                TarjetaHelper::desvincularReservas($res);
            }
    
            if ($tarjeta->delete()) {
                $data['success'] = true;
            }
        }catch(\Exception $e){
            $data['message'] = $e->getMessage();
        }

        return response()->json($data);
    }

    public function editar_estatus($tarjeta_id, $motivo_del_rechazo)
    {

        $tarjeta = Tarjeta::findOrFail($tarjeta_id);

        try {
            if ($tarjeta) {
                $tarjeta->estatus  = $motivo_del_rechazo;
                $tarjeta->modified = Carbon::now();
                $tarjeta->save();
                $res = true;
            }
        } catch (\Exception $e) {
            $res = false;
        }

        return $res;
    }

    public function get_tarjetas(Request $request)
    {
        $tarjetas = Tarjeta::whereHas('r_banco', function ($q) {
            $q->where('paise_id', env('APP_PAIS_ID'));
        });

        return DataTables::eloquent($tarjetas)
            ->addColumn('user', function ($tarjetas) {
                return $tarjetas->user->fullName;
            })

            ->addColumn('titular', function ($tarjetas) {
                return $tarjetas->name;
            })

            ->addColumn('banca', function ($tarjetas) {
                return $tarjetas->banco;
            })

            ->addColumn('entidad', function ($tarjetas) {
                return $tarjetas->r_banco->title;
            })

            ->addColumn('estatus', function ($tarjetas) {
                return $tarjetas->estatus;
            })
            ->editColumn('tipo', function ($tarjetas) {
                return $tarjetas->tipo;
            })
            ->addColumn('actions', function ($tarjetas) {
                $btn = '';

                if (Auth::user()->can('view', $tarjetas)) {
                    $btn .= '<a href="' . route('cards.show', $tarjetas->id) . '" class="dropdown-item"><i class="fas fa-eye"></i> Ver</a>';
                }
                if (Auth::user()->can('update', $tarjetas)) {
                    $btn .= '<a href="' . route('cards.edit', $tarjetas->id) . '" class="dropdown-item"><i class="fas fa-edit"></i> Editar</a>';
                }
                if (Auth::user()->can('delete', $tarjetas)) {
                    $btn .= '<a href="javascript:void(0)" value="' . $tarjetas->id . '" class="dropdown-item" id="btnEliminar"><i class="fas fa-trash-alt"></i> Eliminar</a>';
                }

                $btn = '<div class="btn-group">
                          <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Opciones
                          </button>
                          <div class="dropdown-menu">
                           ' . $btn . '
                          </div>
                        </div>';

                return $btn;
            })
            ->rawColumns(['user', 'titular', 'banca', 'entidad', 'estatus', 'tipo', 'actions'])
            ->make(true);

    }



    /**
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2023-10-09
     * Mostratos el historial de acciones que se han realizado a una tarjeta
     * @param  [int] $id
     * @return [json]
     */
    public function historial($id)
    {
        $tarjeta        = Tarjeta::findOrFail($id);
        $data['success'] = false;
        if ($tarjeta) {
            $data['success']   = true;
            $data['historico'] = $tarjeta->logTarjeta;
        }

        return response()->json($data);
    }
}
