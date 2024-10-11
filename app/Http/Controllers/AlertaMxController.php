<?php

namespace App\Http\Controllers;

use App\AlertaMx;
use App\Convenio;
use App\Exports\AlertasExport;
use App\Mail\Mx\SendAlertMx;
use Carbon\Carbon;
use DB;
use Excel;
use Illuminate\Http\Request;
use Mail;
use Auth;
class AlertaMxController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['viewAlertas', 'filtrarAlertas', 'exportFiltrado', 'downloadFiltrado', 'getDataFiltrado']);
    }
    /**
     * Autor:    Diego Enrique Sanchez
     * Creado:   2021-08-31
     * Accion:   Validacion del formulario de registro de tarjeta a cliente, validacion ajax
     * @param    $request
     * @return   response
     */
    public function validar_form(Request $request, $id = null)
    {

        $validator = \Validator::make($request->all(), [
            'nombre'               => 'required | string | max:40',
            'apellidos'            => 'required | string | max:19',
            'telefono'             => 'required | min:10',
            'username'             => 'required | email',
            'g-recaptcha-response' => 'required | captcha',
        ]);

        return $validator;
    }

    public function alerta_mx(Request $request)
    {

        $data['success'] = false;

        switch (rand(2, 6)) {
            // case 1:
            //     $para = 'claudiac@beneficiosvacacionales.mx';
            //     break;
            case 2:
                $para = 'leslyl@beneficiosvacacionales.mx';
                break;
            case 3:
                $para = 'mvega@beneficiosvacacionales.com';
                break;
            case 4:
                $para = 'ymaciel@misbeneficiosvacacionales.com';
                break;
            case 5:
                $para = 'anitam@beneficiosvacacionales.mx';
                break;
            case 6:
                $para = 'amartinez@misbeneficiosvacacionales.com';
                break;
            default:
                // $para = 'alertasmexico@pacifictravels.mx';
                $para = 'leslyl@beneficiosvacacionales.mx';
                break;
        }

        $validate = $this->validar_form($request);
        if ($validate->fails()) {
            return response()->json(['success' => false, 'errors' => $validate->errors()]);
        }

        $alerta                          = new AlertaMx;
        $alerta->nombre                  = $request->nombre;
        $alerta->apellidos               = $request->apellidos;
        $alerta->email                   = $request->username;
        $alerta->telefono                = $request->telefono;
        $alerta->empresa                 = (session('convenio_nombre') !== null) ? session('convenio_nombre') : 'Invitado Mis Beneficios Vacacionales';
        $alerta->created                 = Carbon::now();
        $alerta->alerta_compra_fecha     = Carbon::now();
        $alerta->alerta_compra_enviada_a = (!is_null($para)) ? $para : 'anitam@beneficiosvacacionales.mx';
        $alerta->convenio_id             = (session('convenio_id') !== null) ? session('convenio_id') : 54513;

        if ($alerta->save()) {

            // Enviar alerta a supervisor
            Mail::to($para)->send(new SendAlertMx($alerta));

            setcookie('preregister_mx', 'true', time() + 482000, '/');
            $data['success'] = true;
        }

        return response()->json($data);
    }

    /**
     * Autor: Isw. Diego Sanchez
     * Creado: 2022-06-09
     * Lanzamos la vista y los convenios para poder realizar la busqueda bajo convenios seleccionados
     * @return $convenios
     */
    public function viewAlertas()
    {
        $this->authorize('ver_alertas', Auth::user());
        // $convenios = Convenio::where('paise_id', 1)->pluck('empresa_nombre', 'id');
        return view('admin.elementos.views.alertas');
    }

    /**
     * Autor: Isw Diego Sanchez
     * Creado: 2022-06-10
     * Listado de alertas dentro de la vista alertas datatables
     * @param  Request $request
     * @return response json
     */
    public function filtrarAlertas(Request $request)
    {

        $alertas = $this->getDataAlertas($request);

        // dd($alertas);

        $data = array();
        $i    = 1;
        $btn  = '';

        foreach ($alertas as $alerta) {
            $data[] = array(
                "0" => $alerta->nombre . ' ' . $alerta->apellidos,
                "1" => $alerta->email,
                "2" => $alerta->telefono,
                "3" => $alerta->empresa,
                "4" => $alerta->alerta_compra_enviada_a,
                "5" => Carbon::create($alerta->created)->diffForHumans(),

                "6" => (Auth::user()->role=='supervisor') ? '<button class="btn btn-sm btn-info">'. ($alerta->alerta_user_enviada == 0) ? 'Nueva' : 'Vista' .'</button>' : '',
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
     * Autor: Isw. Diego Sanchez
     * Creado: 2022-06-14
     * Llamamos la clade "AlertasExport" para generar el archivo excel con el filtrado de alertas solicitadas por el usuario
     * @param  Request $request
     * @return response json
     */
    public function exportAlertas(Request $request)
    {
        $alertas         = $this->getDataAlertas($request);
        $data['name']    = 'Alertas-' . str_replace(' ', '-', Carbon::now()) . '.xlsx';
        $data['success'] = true;
        $data['url']     = route('alertas.download', $data['name']);
        $excel           = Excel::store(new AlertasExport($alertas), $data['name'], 'filtrados');

        return response()->json($data);

    }

    /**
     * Autor: Isw. Diego Sanchez
     * Creado: 2022-06-13
     * Retornamos la descarga para procesarla por ajax y no recargar ni redireccionar al usuario
     * @param  string $name nombre del archivo a descargar
     * @return response download
     */
    public function downloadAlertas($name)
    {
        return response()->download(public_path() . "/files/filtrados/" . $name);
    }

    /**
     * Autor: Isw. Diego Sanchez
     * Creado: 2022-06-13
     * Consilta para obtener el filtrado de las alertas solicitadas por el usuario
     * se usa en mas de un metodo, revisar la modificacion en metodo @exportAlertas y @downloadAlertas
     * @param  Request $request
     * @return array data
     */
    public function getDataAlertas($request)
    {
        if (Auth::user()->role == 'supervisor') {
            switch (Auth::user()->id) {
                case 32254:
                    $para = 'leslyl@beneficiosvacacionales.mx';
                    break;
                case 703953:
                    $para = 'mvega@beneficiosvacacionales.com';
                    break;
                case 699788:
                    $para = 'ymaciel@misbeneficiosvacacionales.com';
                    break;
                case 76:
                    $para = 'anitam@beneficiosvacacionales.mx';
                    break;
                case 684289:
                    $para = 'amartinez@misbeneficiosvacacionales.com';
                    break;
                default:
                    $para = 'leslyl@beneficiosvacacionales.mx';
                    break;
            }
            $alertas = AlertaMx::whereBetween(DB::raw('date(created)'), [$request->fecha_inicio, $request->fecha_fin])
            ->where('alerta_compra_enviada_a', $para)
            ->orderBy('created', 'DESC')->get();

            return $alertas;
        }else{
            $alertas = AlertaMx::whereBetween(DB::raw('date(created)'), [$request->fecha_inicio, $request->fecha_fin]);
            if (isset($request->solo_clientes)) {
                $alertas->whereExists(function($query){
                     $query->select(DB::raw(1))
                      ->from('users')
                      ->whereRaw('users.username = users_alerts_mx.email');
                });
            }
            $alertas->orderBy('created', 'DESC');
            if (isset($request->agrupar)) {
                $alertas->groupBy('email');
            }


            $res = $alertas->get();
            return $res;
        }
    }
}
