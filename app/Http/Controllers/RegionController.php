<?php

namespace App\Http\Controllers;

use App\Region;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', Region::class);
        return view('admin.regiones.index');
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
        $fecha            = Carbon::now();
        $data['success']  = false;
        $region           = new Region;
        $region->paise_id = $request->paise_id;
        $region->title    = $request->title;
        $region->created  = $fecha;
        $region->modified = $fecha;

        if ($region->save()) {
            $data['success'] = true;
        }

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function show(Region $region)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['region']  = Region::findOrFail($id);
        $data['success'] = true;

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data['success']  = false;
        $region           = Region::findOrFail($id);
        $region->title    = $request->title;
        $region->paise_id = $request->paise_id;

        if ($region->save()) {
            $data['success'] = true;
        }

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function destroy(Region $region)
    {
        //
    }

    public function getRegiones()
    {

        $regiones = Region::with(['r_pais', 'temporadas'])->get();
        $data     = array();
        $i        = 1;
        $btn      = '';

        foreach ($regiones as $region) {
            $btn .= '<button id="btnEdit" data-route="' . route('regiones.edit', $region->id) . '" data-route-update="' . route('regiones.update', $region->id) . '" data-id="' . $region->id . '" class="btn btn-primary btn-xs mr-1"><i class="fas fa-edit"></i></button>';

            $btn .= '<button id="btnAddTemporada"  data-id="' . $region->id . '" class="btn btn-info btn-xs mr-1"><i class="fas fa-plus"></i></button>';

            $btn .= '<button id="btnEliminar" data-route="' . route('regiones.destroy', $region->id) . '"  data-id="' . $region->id . '" class="btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></button>';

            $data[] = array(
                "0" => $region->r_pais->title,
                "1" => $region->title,
                "2" => $region->created,
                "3" => '<button type="button" data-id="' . $region->id . '" data-route="' . route('temporadas.show', $region->id) . '" id="btnListarRegiones" class="btn btn-dark btn-xs">' . count($region->temporadas) . ' Temporadas</button>',
                "4" => $btn,
                "5" => $region->id,
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

}
