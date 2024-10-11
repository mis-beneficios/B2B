<?php

namespace App\Http\Controllers;

use App\Notificacion;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNotificacionRequest;
use App\Http\Requests\UpdateNotificacionRequest;
use Illuminate\Http\Request;
use Auth;
use Cache;
use Cookie;

class NotificacionController extends Controller
{
    private $expiracion = 3600;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         // Cache::put('respaldo_calidad', false);
        return view('admin.notificaciones.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.notificaciones.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNotificacionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data['success'] = false;

        $not = new Notificacion;

        $not->nombre        = $request->nombre;
        $not->cuerpo        = $request->cuerpo;
        $not->estatus       = $request->estatus;
        $not->activo_hasta  = $request->activo_hasta;
        $not->show_role     = implode(',', $request->show_role);
        $not->key_cache     = $request->key_cache;
        $not->user_id       = Auth::id();
        if($not->save()){
            $data['success'] = true;
            $data['url']     = route('notificaciones.index');
        }

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notificacion  $notificacion
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['success'] = false;
        $notificacion = Notificacion::findOrFail($id);

        if ($notificacion != null) {
            $data['success'] = true;
            $data['cuerpo'] = $notificacion->cuerpo;
        }

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Notificacion  $notificacion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data['success'] = false;
        $notificacion = Notificacion::findOrFail($id);
        return view('admin.notificaciones.edit', compact('notificacion'));
        // if ($notificacion != null) {
        //     $data['success'] = true;
        //     $data['view'] = view('admin.notificaciones.edit', compact('notificacion'))->render();;
        // }

        // return response()->json($data);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNotificacionRequest  $request
     * @param  \App\Notificacion  $notificacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $data['success'] = false;

        $not = Notificacion::findOrFail($id);

        $not->nombre        = $request->nombre;
        $not->cuerpo        = $request->cuerpo;
        $not->estatus       = $request->estatus;
        $not->activo_hasta  = $request->activo_hasta;
        $not->show_role     = implode(',', $request->show_role);
        $not->key_cache     = $request->key_cache;
        $not->user_id       = Auth::id();
        if($not->save()){
            $data['success'] = true;
            $data['url']     = route('notificaciones.index');
        }

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notificacion  $notificacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notificacion $notificacion)
    {
        //
    }


    public function get_notificaciones()
    {
     
        $notificaciones = Notificacion::all();

        $data     = array();
        $i        = 1;
        $btn      = '';
        $btnPagos = '';

        foreach ($notificaciones as $notificacion) {
            $btn .= '<a href="' . route('notificaciones.show', $notificacion->id) . '" class="btn btn-primary btn-xs mr-1" id="btnVerNotificacion"><i class="fas fa-eye"></i></a>';
            $btn .= '<a href="' . route('notificaciones.edit', $notificacion->id) . '" class="btn btn-success btn-xs mr-1" id="btnEditarNotificacion_"><i class="fas fa-edit"></i></a>';
            $btn .= '<a href="' . route('notificaciones.destroy', $notificacion->id) . '" class="btn btn-danger btn-xs" id="btnEliminarNotificacion"><i class="fas fa-trash-alt"></i></a>';

            if ($notificacion->estatus == 0) {
                $btnEstatus = '<button class="btn btn-xs btn-info">Activa</button>';
            }else{
                $btnEstatus = '<button class="btn btn-xs btn-danger">Inactiva</button>';
            }

            $data[] = array(
                "0" => $notificacion->id,
                "2" => $notificacion->nombre,
                "3" => $btnEstatus,
                "4" => $notificacion->activo_hasta,
                "5" => $notificacion->show_role,
                "6" => $notificacion->key_cache,
                "7" => $notificacion->user->fullName,
                "8" => $btn,
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

    public function ocultar($key_cache)
    {
        // Cookie::put($key_cache, 'true');
        // Cookie::make($key_cache, 'true', $tiempo_expiracion_en_minutos);
        setcookie($key_cache, 'true', time() + $this->expiracion * 5, '/');
        $data['success'] = true;
        return response()->json($data);
    }
}
