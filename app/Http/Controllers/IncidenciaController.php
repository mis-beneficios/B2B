<?php

namespace App\Http\Controllers;

use App\Incidencia;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIncidenciaRequest;
use App\Http\Requests\UpdateIncidenciaRequest;
use Auth;
use Yajra\DataTables\Facades\DataTables;
use DB;

class IncidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Incidencia::class);
        return view('admin.incidencias.index');

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
     * @param  \App\Http\Requests\StoreIncidenciaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIncidenciaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Incidencia  $incidencia
     * @return \Illuminate\Http\Response
     */
    public function show(Incidencia $incidencia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Incidencia  $incidencia
     * @return \Illuminate\Http\Response
     */
    public function edit(Incidencia $incidencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateIncidenciaRequest  $request
     * @param  \App\Incidencia  $incidencia
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIncidenciaRequest $request, Incidencia $incidencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Incidencia  $incidencia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Incidencia $incidencia)
    {
        //
    }


    public function get_incidencias($fecha = null)
    {
        $incidencias = Incidencia::where(DB::raw('date(created)'), $fecha)->orderBy('id', 'DESC');

         return DataTables::eloquent($incidencias)

            ->editColumn('id', function ($incidencias) {
                return ucwords($incidencias->id);
            })

            ->editColumn('caso', function ($incidencias) {
                return $incidencias->caso;
            })

            ->editColumn('descripcion', function ($incidencias) {
                return $incidencias->descripcion ?? $incidencias->caso;
            })

            ->editColumn('created', function ($incidencias) {
                return $incidencias->diffForhumans() ?? 'S/R';
            })

            ->editColumn('user_id', function ($incidencias) {
                return ($incidencias->user->fullName) .' <br> <label class="label label-info">' . $incidencias->user->perfil . ' </label><br>' . $incidencias->user->username ?? 'S/R';
            })
            ->rawColumns(['id', 'caso', 'descripcion', 'clase', 'user_id','created'])
            ->make(true);
    }
}
