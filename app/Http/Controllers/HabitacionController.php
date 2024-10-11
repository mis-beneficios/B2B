<?php

namespace App\Http\Controllers;

use App\Habitacion;
use Illuminate\Http\Request;

class HabitacionController extends Controller
{
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Habitacion  $habitacion
     * @return \Illuminate\Http\Response
     */
    public function show(Habitacion $habitacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Habitacion  $habitacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Habitacion $habitacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Habitacion  $habitacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Habitacion $habitacion)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Habitacion  $habitacion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data['success'] = false;
        $habitacion      = Habitacion::findOrFail($id);
        // dd($habitacion);
        if ($habitacion->delete()) {
            $data['success'] = true;
        }

        return response()->json($data);
    }

    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2022-12-20
     * Elimina el Jr de la habitacion, restando un registro al numero de jrs
     * Revisar metodo y automaticar junto con deleteJunior
     * @param  [int] $id
     * @param  [int] $junior_id
     * @return [json] $data
     */
    public function deleteMenor($id, $nino_id)
    {
        $data['success'] = false;
        $menor           = 'edad_menor_' . $nino_id;
        $habitacion      = Habitacion::findOrFail($id);
        $habitacion->menores--;
        $habitacion[$menor] = 0;

        if ($habitacion->save()) {
            $data['success'] = true;
        }

        return response()->json($data);
    }

    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2022-12-21
     * Elimina el Jr de la habitacion, restando un registro al numero de jrs
     * Revisar metodo y automaticar junto con deleteMenor
     * @param  [int] $id
     * @param  [int] $junior_id
     * @return [json] $data
     */
    public function deleteJunior($id, $junior_id)
    {
        $data['success'] = false;
        $menor           = 'edad_junior_' . $junior_id;
        $habitacion      = Habitacion::findOrFail($id);
        $habitacion->juniors--;
        $habitacion[$menor] = 0;

        if ($habitacion->save()) {
            $data['success'] = true;
        }

        return response()->json($data);
    }
}
