<?php

namespace App\Http\Controllers;

use App\AlertaUsa;
use App\Mail\Usa\AlertaUsa as SendAlerta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mail;

class AlertaUsaController extends Controller
{
    public function alerta_usa(Request $request)
    {

        $alerta                          = new AlertaUsa;
        $alerta->nombre                  = $request->first_name;
        $alerta->apellidos               = $request->last_name;
        $alerta->email                   = $request->email;
        $alerta->telefono                = $request->phone;
        $alerta->empresa                 = (session('convenio_nombre') !== null) ? session('convenio_nombre') : 'United States';
        $alerta->place                   = $request->place;
        $alerta->compania                = $request->company;
        $alerta->people                  = $request->num_people;
        $alerta->date_travel             = $request->date_travel;
        $alerta->created                 = Carbon::now();
        $alerta->alerta_compra_fecha     = Carbon::now();
        $alerta->alerta_compra_enviada_a = '';
        $alerta->convenio_id             = (session('convenio_id') !== null) ? session('convenio_id') : 70;
        $alerta->url                     = $request->url();

        if ($alerta->save()) {
            Mail::to('dsanchez@pacifictravels.mx')->send(new SendAlerta($alerta));
            setcookie('preregister', 'true', time() + 482000, '/');
            $data['success'] = true;
        }

        return response()->json($data);
    }

    public function enviar_alerta($alerta = null)
    {
        // $data = array('name' => "Virat Gandhi");
        // Mail::send('text', $data, function ($message) {
        //     $message->to('abc@gmail.com', 'Tutorials Point')
        //         ->subject('Laravel HTML Testing Mail');
        //     $message->from('mailer@pacifictravels.mx', 'Pacific Travels');
        // });
    }
}
