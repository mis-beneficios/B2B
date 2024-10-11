<?php

namespace App\Http\Controllers\Cliente;

use App\Contrato;
use App\Helpers\PagosHelper;
use App\Http\Controllers\Controller;
use App\Pago;
use Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{
    public $pagos;
    public function __construct()
    {
        $this->middleware('auth');
        $this->pagos = new PagosHelper;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cliente.perfil');
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
        //
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

    public function obtener_contratos()
    {
        $contratos = Contrato::where('user_id', Auth::id())->get();

        return Datatables::of($contratos)
            ->addColumn('id', function ($contratos) {
                return $contratos->id;
            })
            ->addColumn('convenio', function ($contratos) {
                return $contratos->convenio->empresa_nombre;
            })
            ->addColumn('estancia', function ($contratos) {
                return $contratos->estancia->title;
            })
            ->addColumn('monto_pendiente', function ($contratos) {
                // $pagados = Pago::where(['contrato_id' => $contratos->id])
                //     ->whereIn('estatus', ['Por Pagar', 'Rechazado'])
                //     ->sum('cantidad');
                // return '$' . number_format($pagados, 2) . ' ' . $contratos->divisa;

                $pagados = Pago::where(['contrato_id' => $contratos->id, 'estatus' => 'Pagado'])->where('segmento', '!=' , 0)->where('cantidad', '!=', '200.00')->sum('cantidad');
                $restante = $contratos->precio_de_compra - $pagados;
                return '$' . number_format($restante, 2) . ' ' . $contratos->divisa;
            })
            
            ->addColumn('monto_pagado', function ($contratos) {
                $pagados = Pago::where(['contrato_id' => $contratos->id, 'estatus' => 'Pagado'])->where('segmento', '!=' , 0)->where('cantidad', '!=', '200.00')->sum('cantidad');
                return '$' . number_format($pagados, 2) . ' ' . $contratos->divisa;
            })
            
            ->editColumn('created', function ($contratos) {
                return $contratos->diffForhumans();
            })
            ->addColumn('proceso', function ($contratos) {
                // return ($contratos->r_reservacion === null) ? 'S/R' : 'En proceso';
                return $contratos->r_reservacion;

            })
            ->addColumn('action', function ($contratos) {
                return '<a href="' . route('paquetes.show', $contratos->id) . '" data-id="' . $contratos->id . '"  id="btnVer" class="btn waves-effect waves-light btn-info btn-sm"><i class="fa fa-eye"></i></a> ' .

                '<a href="javascript:void(0)" data-id="' . $contratos->id . '"   id="btnPagos" class="btn waves-effect waves-light btn-success btn-sm"><i class="fa fa-dollar"></i></a> ' .

                '<a href="javascript:void(0)" data-id="' . $contratos->id . '"  data-pais_id="' . $contratos->estancia->estancia_paise_id . '" id="btnContrato" class="btn waves-effect waves-light btn-warning btn-sm"><i class="fa fa-file-pdf-o"></i></a> ';

                // '<a href="javascript:void(0)" data-id="' . $contratos->id . '"  id="btnReservar" class="btn waves-effect waves-light btn-primary btn-sm"><i class="fa fa-calendar"></i></a> ';
            })
            ->make(true);

    }

    public function obtener_pagos($contrato_id)
    {
        // return $this->pagos->get_pagos_contrato($contrato_id);
        $pagos = Pago::where('contrato_id', $contrato_id)
            ->where('cantidad', '!=', 0.00)
            ->get();

        return Datatables::of($pagos)
            ->editColumn('cantidad', function ($pagos) {
                return '$' . number_format($pagos->cantidad, 2) . ' ' . $pagos->contrato->divisa;
            })
            ->setRowClass(function ($pagos) {
                switch ($pagos->estatus) {
                    case 'Por Pagar':
                        $class = 'alert-warning';
                        break;

                    case 'Pagado':
                        $class = 'alert-info';
                        break;

                    default:
                        $class = 'alert-danger';
                        break;

                }
                return $class;

            })
            ->make(true);

    }

}
