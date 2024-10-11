<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\JobNotifications;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JobNotificationsController extends Controller
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
     * @param  \App\Http\Requests\StoreJobNotificationsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data['success'] = false;
        $fechas          = explode(' al ', $request->fechas);
        $fecha_inicio    = $fechas[0];
        $fecha_fin       = $fechas[1];
        $name            = 'Comisiones-' . $fecha_inicio . '-al-' . $fecha_fin . '-' . Carbon::now()->format('hi') . '.xlsx';

        $notificacion           = new JobNotifications;
        $notificacion->numero   = $request->telefono;
        $notificacion->job_name = $name;
        $notificacion->estatus  = 0;
        $notificacion->file     = 'Archivo listo, descargar: ' . route('comisiones.download', $name);
        $notificacion->tipo     = 'comisiones';
        $notificacion->user_id  = Auth::id();

        if ($notificacion->save()) {
            $data['success']      = true;
            $data['request']      = $request->all();
            $data['notificacion'] = $notificacion;

        }

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\JobNotifications  $jobNotifications
     * @return \Illuminate\Http\Response
     */
    public function show(JobNotifications $jobNotifications)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JobNotifications  $jobNotifications
     * @return \Illuminate\Http\Response
     */
    public function edit(JobNotifications $jobNotifications)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateJobNotificationsRequest  $request
     * @param  \App\JobNotifications  $jobNotifications
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJobNotificationsRequest $request, JobNotifications $jobNotifications)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JobNotifications  $jobNotifications
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobNotifications $jobNotifications)
    {
        //
    }

}
