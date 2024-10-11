<?php

namespace App\Http\Controllers;

use App\Temporada;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TemporadaController extends Controller
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
        $temporadas = [];
        try {
            foreach ($request->temporada as $key => $value) {

                Temporada::create(
                    [
                        'regione_id'       => $request->region_id,
                        'title'            => $value,
                        'fecha_de_inicio'  => $request->fecha_inicio[$key],
                        'fecha_de_termino' => $request->fecha_fin[$key],
                        'created'          => Carbon::now(),
                        'updated'          => Carbon::now(),
                    ],

                );
            }
            $data['success'] = true;
        } catch (Exception $e) {
            $data['success'] = false;
            $data['errors']  = $e;

        }
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Temporada  $temporada
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $year_star  = date('Y') - 3;
        $temporadas = Temporada::where('regione_id', $id)->orderBy('created', 'DESC')->get();

        $data = array();
        $i    = 1;
        $btn  = '';

        foreach ($temporadas as $temporada) {

            // $btn .= '<a href="#" class="btn btn-info btn-xs mr-2"><i class="fas fa-eye"></i></a>';
            $btn .= '<button id="btnEditTemporada" data-route="' . route('temporadas.edit', $temporada->id) . '" data-route-update="' . route('temporadas.update', $temporada->id) . '" data-id="' . $temporada->id . '" data-region_id="' . $temporada->regione_id . '" class="btn btn-primary btn-xs mr-1"><i class="fas fa-edit"></i></button>';

            $btn .= '<button id="btnEliminarTemporada" data-route="' . route('temporadas.destroy', $temporada->id) . '" data-id="' . $temporada->id . '" class="btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></button>';

            $data[] = array(
                "0" => $temporada->title,
                "1" => $temporada->fecha_de_inicio,
                "2" => $temporada->fecha_de_termino,
                "3" => $btn,
                "5" => $temporada->id,
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Temporada  $temporada
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $temporada       = Temporada::findOrFail($id);
            $data['view']    = view('admin.temporadas.edit', compact('temporada'))->render();
            $data['success'] = true;
        } catch (\Exception $e) {
            $data['errores'] = $e->getMessage();
            $data['success'] = false;

        }
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Temporada  $temporada
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $temporada                   = Temporada::findOrFail($id);
            $temporada->title            = $request->temporada;
            $temporada->fecha_de_inicio  = $request->fecha_inicio;
            $temporada->fecha_de_termino = $request->fecha_fin;
            if ($temporada->save()) {
                $data['success']   = true;
                $data['temporada'] = $temporada;
            }
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['errores'] = $e->getMessage();
        }

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Temporada  $temporada
     * @return \Illuminate\Http\Response
     */
    public function destroy(Temporada $temporada)
    {
        $data['success'] = false;
        if ($temporada->delete()) {
            $data['success'] = true;
        };

        return response()->json($data);
    }
}
