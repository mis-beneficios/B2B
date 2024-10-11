<?php

namespace App\Http\Controllers\Cliente;

use App\Banco;
use App\Http\Controllers\Controller;
use App\Tarjeta;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TarjetaController extends Controller
{

    public $numRegistros = 1;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function validar_form_card(Request $request, $id = null)
    {

        $validator = \Validator::make($request->all(), [
            'titular'        => 'required | string | max:40',
            'numero_tarjeta' => 'required | string | min:19',
            'red_bancaria'   => 'required',
            'banco_id'       => 'required',
            'tipo'           => 'required',
            'vencimiento'    => 'required',
            // 'vencimiento'    => 'required|regex:/^[0-9]{2}(\/?)[0-9]{2}$/',
            'cvv'            => 'required',
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
        return view('cliente.tarjetas.index');
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

        $res['success'] = false;
        $validate       = $this->validar_form_card($request);
        if ($validate->fails()) {
            return response()->json(['success' => false, 'errors' => $validate->errors()]);
        }

        $cardCount = Tarjeta::where('numero', $request->numero_tarjeta)->count();

        if ($cardCount >= $this->numRegistros) {
            return response()->json(['success' => false, 'message' => 'El número de la tarjeta ya ha sido registrada más de ' . $this->numRegistros . ' ocasiones']);
            exit();
        }



        $vence = explode('/', $request->vencimiento);
        $fecha = Carbon::now();

        $tarjeta                       = new Tarjeta;
        $tarjeta->user_id              = Auth::user()->id;
        $tarjeta->banco_id             = $request->banco_id;
        $tarjeta->name                 = $request->titular;
        $tarjeta->banco                = $request->red_bancaria;
        $tarjeta->numero               = str_replace('-', '', $request->numero_tarjeta);
        $tarjeta->mes                  = $vence[0];
        $tarjeta->ano                  = $vence[1];
        $tarjeta->cvv2                 = $request->cvv;
        $tarjeta->estatus              = 'Sin Verificar';
        $tarjeta->historico_de_pagos   = 'al_corriente';
        $tarjeta->tipo                 = $request->tipo;
        $tarjeta->created              = $fecha;
        $tarjeta->importado            = 0;
        $tarjeta->tipocuenta           = '03';
        $tarjeta->autorizo             = 1;
        $tarjeta->agreeterms           = 1;
        $tarjeta->firstpaymentdeducted = 0;

        if ($tarjeta->save()) {
            $res['success'] = true;
        }

        return response()->json($res);
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

    public function obtener_tarjetas($user_id = null)
    {
        $tarjetas = Tarjeta::where('user_id', Auth::user()->id)->get();
        return Datatables::of($tarjetas)
            ->addIndexColumn()
            ->editColumn('numero', function ($tarjetas) {
                return $tarjetas->numeroTarjeta;
            })
            ->addColumn('vencimiento', function ($tarjetas) {
                return (($tarjetas->mes < 10) ? '0' . $tarjetas->mes : $tarjetas->mes) . '/' . $tarjetas->ano;
            })
            ->addColumn('banco_id', function ($tarjetas) {
                return $tarjetas->r_banco->title;
            })
            ->editColumn('name', function ($tarjetas) {
                return ($tarjetas->name != null) ? $tarjetas->name : $tarjetas->user->fullName;
            })

        // ->addColumn('action', function ($tarjetas) {
        //     return '<a href="' . route('paquetes.show', $tarjetas->id) . '" data-id="' . $tarjetas->id . '"  id="btnVer" class="btn waves-effect waves-light btn-info btn-sm"><i class="fa fa-eye"></i></a> ' .

        //     '<a href="javascript:void(0)" data-id="' . $tarjetas->id . '"  id="btnPagos" class="btn waves-effect waves-light btn-success btn-sm"><i class="fa fa-dollar"></i></a> ' .

        //     '<a href="javascript:void(0)" data-id="' . $tarjetas->id . '"  id="btnContrato" class="btn waves-effect waves-light btn-warning btn-sm"><i class="fa fa-file-pdf-o"></i></a> ' .

        //     '<a href="javascript:void(0)" data-id="' . $tarjetas->id . '"  id="btnReservar" class="btn waves-effect waves-light btn-primary btn-sm"><i class="fa fa-calendar"></i></a> ';
        // })
            ->make(true);
    }

    public function obtener_bancos()
    {
        $bancos = Banco::where('paise_id', env('APP_PAIS_ID'))->get();
        return response()->json($bancos);
    }

}
