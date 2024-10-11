<?php

namespace App\Http\Controllers;

use App\Mail\Mx\EnviarSorteo;
use App\SorteoConvenio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mail;

class SorteoConvenioController extends Controller
{

    public function __construct()
    {

    }

    public function validar_form($request, $validar_correo = true)
    {
        $validator = \Validator::make($request->all(), [
            'nombre'                 => 'required | string | max:40',
            'apellidos'              => 'required | string | max:40',
            'email'                  => ($validar_correo == true) ?  'required | email' : 'required | email | unique:concursoconvenios,email',
            'telefono_celular'       => 'required | numeric | digits:10',
            'telefono_casa'          => 'required | numeric | digits:10',
            'numero_empleado'        => ($request->sorteo_especial == 1) ? 'required | numeric' : '',
            'sucursal'               => ($request->sorteo_especial == 1) ? 'required' : '',
            'nom_empresa'            => ($request->sorteo_especial == 1) ? 'required' : '',
            'terminos_y_condiciones' => 'accepted',
            'g-recaptcha-response'   => 'required | captcha',
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
        $sorteo = SorteoConvenio::find(19430);
        return view('mails.mx.enviar_sorteo', compact('sorteo'));
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

        dd($request->all());
        $res = SorteoConvenio::where(['folioNo'=> $request->sorteo_id, 'email'  => $request->email])->first();

        // if ($res == null) {
        //     $validar_correo = true;
        // }else{
        //     $validar_correo = false;
        // }
        
        $validar_correo = ($res == null) ? true : false;


        $validate = $this->validar_form($request, $validar_correo);
        if ($validate->fails()) {
            return response()->json(['success' => false, 'errors' => $validate->errors()]);
        }
        $fecha                    = Carbon::now();
        $sorteo                   = new SorteoConvenio;
        $sorteo->nombre_completo  = $request->nombre;
        $sorteo->apellidos        = $request->apellidos;
        $sorteo->email            = $request->email;
        $sorteo->empresa          = $request->empresa_nombre; 
        $sorteo->telefono_casa    = $request->telefono_casa;
        $sorteo->telefono_celular = $request->telefono_celular;
        $sorteo->publicidad       = $request->publicidad;
        $sorteo->terminos         = $request->terminos_y_condiciones;

        $sorteo->sucursal         = $request->sucursal;
        $sorteo->nom_empresa      = $request->nom_empresa;
        $sorteo->numero_empleado  = $request->numero_empleado;
        $sorteo->folioNo          = $request->sorteo_id;
        
        $sorteo->created  = $fecha;
        $sorteo->modified = $fecha;

        if ($sorteo->save()) {
            $res['success'] = true;
            $res['sorteo']  = $sorteo;
            try {
                Mail::to($sorteo->email)->send(new EnviarSorteo($sorteo));
                $res['notification'] = true;
            } catch (\Exception $e) {
                $res['notification'] = false;
            }
        }

        return response()->json($res);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SorteoConvenio  $sorteoConvenio
     * @return \Illuminate\Http\Response
     */
    public function show(SorteoConvenio $sorteoConvenio)
    {

        return view('admin.sorteo.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SorteoConvenio  $sorteoConvenio
     * @return \Illuminate\Http\Response
     */
    public function edit(SorteoConvenio $sorteoConvenio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SorteoConvenio  $sorteoConvenio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SorteoConvenio $sorteoConvenio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SorteoConvenio  $sorteoConvenio
     * @return \Illuminate\Http\Response
     */
    public function destroy(SorteoConvenio $sorteoConvenio)
    {
        //
    }



    public function validar_form_especial($request, $validar_correo = true)
    {
        $validator = \Validator::make($request->all(), [
            'nombre'                 => 'required | string | max:40',
            'apellidos'              => 'required | string | max:40',
            'email'                  => ($validar_correo == true) ?  'required | email' : 'required | email | unique:concursoconvenios,email',
            'telefono_celular'       => 'required | numeric | digits:10',
            'telefono_casa'          => 'required | numeric | digits:10',
            'el_mas_chistoso'        => 'required|file|mimes:jpeg,png,mp4,avi,mov,flv|max:10240', // Máximo 10 MB
            'el_mas_divertido'       => 'required|file|mimes:jpeg,png,mp4,avi,mov,flv|max:10240', // Máximo 10 MB
            'el_mas_romantico'       => 'required|file|mimes:jpeg,png,mp4,avi,mov,flv|max:10240', // Máximo 10 MB

            'uso_multimedia' => 'accepted',
            'g-recaptcha-response'   => 'required | captcha',
        ]);
        return $validator;
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSorteo(Request $request)
    {
        dd($request->all());
        $res['success'] = false;

        $res = SorteoConvenio::where(['folioNo'=> $request->sorteo_id, 'email'  => $request->email])->first();

        // if ($res == null) {
        //     $validar_correo = true;
        // }else{
        //     $validar_correo = false;
        // }
        
        $validar_correo = ($res == null) ? true : false;


        $validate = $this->validar_form_especial($request, $validar_correo);
        if ($validate->fails()) {
            return response()->json(['success' => false, 'errors' => $validate->errors()]);
        }


        $fecha                    = Carbon::now();
        $sorteo                   = new SorteoConvenio;
        $sorteo->nombre_completo  = $request->nombre;
        $sorteo->apellidos        = $request->apellidos;
        $sorteo->email            = $request->email;
        $sorteo->empresa          = $request->empresa_nombre; 
        $sorteo->telefono_casa    = $request->telefono_casa;
        $sorteo->telefono_celular = $request->telefono_celular;
        $sorteo->publicidad       = $request->publicidad;
        $sorteo->terminos         = $request->terminos_y_condiciones;

        $sorteo->sucursal         = $request->sucursal;
        $sorteo->nom_empresa      = $request->nom_empresa;
        $sorteo->numero_empleado  = $request->numero_empleado;
        $sorteo->folioNo          = $request->sorteo_id;
        
        $sorteo->created  = $fecha;
        $sorteo->modified = $fecha;

        if ($sorteo->save()) {
            $res['success'] = true;
            $res['sorteo']  = $sorteo;
            try {
                Mail::to($sorteo->email)->send(new EnviarSorteo($sorteo));
                $res['notification'] = true;
            } catch (\Exception $e) {
                $res['notification'] = false;
            }
        }

        return response()->json($res);
    }

}
