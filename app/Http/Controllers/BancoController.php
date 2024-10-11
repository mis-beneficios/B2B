<?php

namespace App\Http\Controllers;

use App\Banco;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class BancoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->authorize('view', Auth::user());
        return view('admin.bancos.index');
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

        $banco                        = new Banco;
        $data['success']              = false;
        $banco->title                 = $request->title;
        $banco->clave                 = ($request->clave) ? $request->clave : '000' ;
        $banco->ignorar_en_via_serfin = $request->ignorar_en_via_serfin;
        $banco->paise_id              = $request->paise_id;
        $banco->created               = Carbon::now();
        $banco->modified              = Carbon::now();

        if ($banco->save()) {
            $data['success'] = true;
        }

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Banco  $banco
     * @return \Illuminate\Http\Response
     */
    public function show(Banco $banco)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Banco  $banco
     * @return \Illuminate\Http\Response
     */
    public function edit(Banco $banco)
    {

        // $data['success'] = false;
        // if ($banco) {
        $data['success'] = true;
        $data['banco']   = $banco;
        // }

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Banco  $banco
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banco $banco)
    {

        $data['success']              = false;
        $banco->title                 = $request->title;
        $banco->clave                 = $request->clave;
        $banco->ignorar_en_via_serfin = $request->ignorar_en_via_serfin;
        $banco->paise_id              = $request->paise_id;
        $banco->created               = Carbon::now();
        $banco->modified              = Carbon::now();

        if ($banco->save()) {
            $data['success'] = true;
        }

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Banco  $banco
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banco $banco)
    {
        //
    }

    public function getBancos()
    {

        $bancos = Banco::with('pais')->where('paise_id', 1)->get();
        // dd($bancos);
        $data = array();
        $i    = 1;
        $btn  = '';
        foreach ($bancos as $banco) {
            if ($banco->ignorar_en_via_serfin == 0) {
                $label = '<label class="label label-info">No</label>';
            } else {
                $label = '<label class="label label-warning">Si</label>';
            }

            // $btn .= '<a href="#" class="btn btn-info btn-xs mr-2"><i class="fas fa-eye"></i></a>';
            $btn .= '<button id="btnEdit" data-route="' . route('bancos.edit', $banco->id) . '" data-route-update="' . route('bancos.update', $banco->id) . '" data-id="' . $banco->id . '" class="btn btn-success btn-xs"><i class="fas fa-edit"></i></button>';
            $data[] = array(
                "0" => $banco->id,
                "1" => $banco->title,
                "2" => $banco->clave,
                "3" => $banco->pais->title,
                "4" => $label,
                "5" => $btn,
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

    public function obtener_bancos()
    {
        $bancos =  Banco::where('paise_id', env('APP_PAIS_ID'))->get(['id', 'title']);
        return response()->json($bancos);
    }
}
