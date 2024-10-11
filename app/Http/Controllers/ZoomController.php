<?php

namespace App\Http\Controllers;

use App\Zoom;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreZoomRequest;
use App\Http\Requests\UpdateZoomRequest;
use Illuminate\Http\Request;
use App\Traits\Meeting;
use Carbon\Carbon;
use Auth;
use GuzzleHttp;
use DataTables;
// use Zoom as ZoomApi;
// use App\Traits\ZoomMeetingTrait;

class ZoomController extends Controller
{

    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;


    use Meeting;
    // ZoomMeetingTrait;

    /**
     * Validacion de formulario para crear reunion en zoom
     * Autor: Diego Enrique Sanchez
     * Creado: 2024-01-16
     * @param  Request $request
     * @param  Int  $id  validar datos del usuario existente
     * @return validacion
     */
    public function validar_form(Request $request, $method = 'POST', $user = null)
    {
        $validator = \Validator::make($request->all(), [
            'topic'             => 'required',
            'agenda'            => 'required',
            'start_date'        => 'required',
            'start_time'        => 'required',
            'duration_h'        => 'required',
            'duration_m'        => 'required',
            'timezone'          => 'required',
            'password'          => 'required | integer | numeric',
            'host_video'        => 'required',
            'participant_video' => 'required',
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
        return view('admin.zoom.index');
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
     * @param  \App\Http\Requests\StoreZoomRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data['success'] = false;
        
        $validate = $this->validar_form($request);
        if ($validate->fails()) {
            return response()->json(['success' => false, 'errors' => $validate->errors()]);
        }
        
        $res = $this->createMeet($request->all());

        if ($res['success'] == true) {

            $zoom               = new Zoom;
            $zoom->user_id      = Auth::user()->id;
            $zoom->url          = $res['meeting']['join_url'];
            $zoom->start_url    = $res['meeting']['start_url'];
            $zoom->join_url     = $res['meeting']['join_url'];
            $zoom->password     = $res['meeting']['password'];
            $zoom->estatus      = $res['meeting']['status'];
            $zoom->fecha        = Carbon::create($res['meeting']['start_time'])->format('Y-m-d H:i');
            $zoom->duracion     = $res['meeting']['duration'];
            $zoom->topic        = $res['meeting']['topic'];
            $zoom->agenda       = $res['meeting']['agenda'];
            $zoom->host_id      = $res['meeting']['host_id'];
            $zoom->meeting_id   = $res['meeting']['id'];
            if($zoom->save()){
                $data['success'] = true;
                $data['meeting'] = $res['meeting'];
            }           
        }else{
            $data['message'] = '¡No se pudo crear la reunión, contacta al administrador de sistema!';
        }

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Zoom  $zoom
     * @return \Illuminate\Http\Response
     */
    public function show($meeting_id)
    {
        $meeting = $this->getMeet($meeting_id);
        $data['success']    = $meeting['success'];
        $data['data']       = $meeting['data'];
        $data['view']       = view('admin.zoom.show', compact('meeting'))->render();

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Zoom  $zoom
     * @return \Illuminate\Http\Response
     */
    public function edit(Zoom $zoom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateZoomRequest  $request
     * @param  \App\Zoom  $zoom
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateZoomRequest $request, Zoom $zoom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Zoom  $zoom
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zoom $zoom)
    {
        //
    }

    public function get_meetings()
    {
        $meetings = Zoom::orderBy('fecha', 'ASC');


        return DataTables::eloquent($meetings)
            ->editColumn('user_id', function($meetings){
                return "<span>".$meetings->user->fullName." <br><small>". $meetings->user->role ."</small></span>";
            })
            ->editColumn('start_url', function($meetings){
                if (Auth::user()->role == 'admin' || Auth::user()->id == $meetings->user_id) {
                    $btn = "<a href='$meetings->start_url' target='_blank' class='btn btn-sm btn-info'>Iniciar Zoom</a>";    
                }else{
                    $btn = "<a href='$meetings->start_url' target='_blank' disabled class='btn btn-sm btn-info disabled'>Iniciar Zoom</a>";
                }
                
                return $btn;
            })
            ->editColumn('url', function($meetings){
                if (Auth::user()->role == 'admin' || Auth::user()->id == $meetings->user_id) {
                    $btn = "<a href='$meetings->start_url' class='btn btn-sm btn-info'>Iniciar Zoom</a>";    
                }else{
                    $btn = "";
                }
                
                return $btn;
            })
            
            ->editColumn('topic', function($meetings){
                return "<span>".$meetings->topic."<span> <br><small>".$meetings->agenda."</small>";
            })


            ->editColumn('created_at', function ($meetings) {
                return Carbon::create($meetings->created_at)->format('Y-m-d h:i A');
            })
            ->editColumn('fecha', function ($meetings) {
                return Carbon::create($meetings->fecha)->format('Y-m-d h:i A');
            })
            ->addColumn('actions', function($meetings){
                if (Auth::user()->role == 'admin' || Auth::user()->id == $meetings->user_id) {
                    $btn = '<button class="btn btn-sm btn-dark" data-url="'.route('zoom.show', $meetings->meeting_id).'" data-meeting_id="'.$meetings->meeting_id.'" id="btnInfoMeeting"><i class="fa fa-copy"></i> Copiar invitación</button>';   
                }else{
                    $btn = "";
                }
                return $btn;
            })
            ->rawColumns(['id', 'user_id', 'url', 'start_url', 'actions', 'fecha', 'created_at', 'topic'])
            ->make(true);
    }
}
