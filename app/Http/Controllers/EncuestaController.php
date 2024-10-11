<?php

namespace App\Http\Controllers;

use App\Encuesta;
use App\Mail\Mx\EncuestaCalidad;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Log;
use Mail;

class EncuestaController extends Controller
{

    /**
     * Validacion de formulario para crear contrato
     * Autor: Diego Enrique Sanchez
     * Creado: 2023-02-22
     * @param  Request $request
     * @param  Int  $id  validar datos del usuario existente
     * @return validacion
     */
    public function validar_form(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'comentario_1' => 'required',
            'comentario_2' => 'required',
            'comentario_3' => 'required',
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
        //
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

        $validate = $this->validar_form($request);

        if ($validate->fails()) {
            return response()->json(['success' => false, 'errors' => $validate->errors()]);
        }

        // dd($request->all());
        $user = $user = User::where('id', $request->user_id)->where('user_hash', $request->user_hash)->first();

        $data['success'] = false;
        if ($user) {

            $encuesta = new Encuesta;

            $encuesta->nombre         = $user->nombre;
            $encuesta->apellidos      = $user->apellidos;
            $encuesta->telefono       = $user->telefono;
            $encuesta->correo         = $user->username;
            $encuesta->user_id        = $user->id;
            $encuesta->reservacion_id = $request->reservacion_id;
            $encuesta->pregunta_1     = $request->pregunta_1;
            $encuesta->comentario_1   = $request->comentario_1;
            $encuesta->pregunta_2     = $request->pregunta_2;
            $encuesta->comentario_2   = $request->comentario_2;
            $encuesta->pregunta_3     = $request->pregunta_3;
            $encuesta->comentario_3   = $request->comentario_3;
            $encuesta->tipo_encuesta  = 1;
            $encuesta->created        = Carbon::now();
            $encuesta->modified       = Carbon::now();

            $encuesta->save();
            try {
                Mail::to('calidad@beneficiosvacacionales.com')->send(new EncuestaCalidad($encuesta));
                Log::notice('Se ha enviado encuesta a calidad');
            } catch (\Exception $e) {
                Log::notice('No se pudo enviar la encuesta a calidad; ' . $e->getMessage());
            }

            $data['success'] = true;
        }

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Encuesta  $encuesta
     * @return \Illuminate\Http\Response
     */
    public function show(Encuesta $encuesta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Encuesta  $encuesta
     * @return \Illuminate\Http\Response
     */
    public function edit(Encuesta $encuesta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Encuesta  $encuesta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Encuesta $encuesta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Encuesta  $encuesta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Encuesta $encuesta)
    {
        //
    }
}
