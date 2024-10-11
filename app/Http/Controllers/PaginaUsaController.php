<?php

namespace App\Http\Controllers;

use App;
use App\CodigoPostal as CP;
use App\Convenio;
use App\Destino;
use App\Estancia;
use App\Hotel;
use DB;

class PaginaUsaController extends Controller
{

    protected $convenio = 128;

    public function __construct()
    {
        $this->convenio = env('APP_ID');
    }
    public function index()
    {

        // $convenio = Convenio::where('llave', $this->convenio)->first();
        // session([
        //     'convenio_nombre' => $convenio->empresa_nombre,
        //     'convenio_id'     => $convenio->id,
        //     'welcome'         => $convenio->welcome,
        // ]);
        // App::setLocale('en');
        // return view('pagina.usa.productos', compact('convenio'));

        return redirect()->route('eu.productos');
    }
    public function fraude()
    {
        return view('pagina.usa.fraude');
    }

    public function mision()
    {
        return view('pagina.usa.mision');
    }

    public function privacidad()
    {
        return view('pagina.usa.privacidad');
    }

    public function bolsa_trabajo()
    {
        return view('pagina.usa.bolsa_trabajo');
    }

    public function empresas_afiliadas()
    {
        return view('pagina.usa.empresas_afiliadas');
    }

    public function beneficios_empresa()
    {
        return view('pagina.usa.beneficios_empresa');
    }

    public function beneficios_trabajadores()
    {
        return view('pagina.usa.beneficios_trabajadores');
    }

    public function productos($convenio = 'mytravel', $producto = null, $producto2 = null)
    {
        if ($convenio == null) {
            $convenio = 'usoptucorp';
        } else {
            if ($convenio != null) {
                $convenio = $convenio;
            } else {
                $convenio = session('llave');
            }
        }

        $convenio = Convenio::where('llave', $convenio)->first();

        session([
            'convenio_nombre' => $convenio->empresa_nombre,
            'convenio_id'     => $convenio->id,
            'welcome'         => $convenio->welcome,
            'llave'           => $convenio->llave,
        ]);

        // dd(session('llave'));
        // if (isset($producto)) {
        switch ($producto) {
            case 'puntacana':
                return $this->puntacana($convenio->llave);
                break;

            default:

                return view('pagina.usa.productos', compact('convenio'));
                break;
        }
        // }

        // if (!$producto == 'national-destinations') {
        // } else {
        //     return redirect()->route('nacionales', $convenio);
        // }
    }

    public function top_eu($convenio = 'mytravel')
    {

        $convenio = Convenio::where('llave', $convenio)->select('id', 'llave', 'empresa_nombre', 'welcome')->first();
        session([
            'convenio_nombre' => $convenio->empresa_nombre,
            'convenio_id'     => $convenio->id,
            'welcome'         => $convenio->welcome,
        ]);

        $destinos = Destino::where('top_id', 'eu')->get();
        return view('pagina.usa.top_eu', compact('destinos', 'convenio'));
    }

    public function top_europa($convenio = 'mytravel')
    {
        $convenio = Convenio::where('llave', $convenio)->select('id', 'llave', 'empresa_nombre', 'welcome')->first();
        session([
            'convenio_nombre' => $convenio->empresa_nombre,
            'convenio_id'     => $convenio->id,
            'welcome'         => $convenio->welcome,
        ]);

        $destinos = Destino::where('top_id', 'europa')->get();
        return view('pagina.usa.top_europa', compact('destinos', 'convenio'));
    }

    public function top_caribbean($convenio = 'mytravel')
    {
        $convenio = Convenio::where('llave', $convenio)->select('id', 'llave', 'empresa_nombre', 'welcome')->first();
        session([
            'convenio_nombre' => $convenio->empresa_nombre,
            'convenio_id'     => $convenio->id,
            'welcome'         => $convenio->welcome,
        ]);

        $destinos = Destino::where('top_id', 'caribe')->get();
        return view('pagina.usa.top_caribbean', compact('destinos', 'convenio'));
    }

    public function listado_productos_top($top, $convenio = 'mytravel')
    {
        switch ($top) {
            case 'eu':
                $img_header   = 'images/eu/nacionales.jpg';
                $title_header = ' U.S.';
                break;
            case 'europa':
                $img_header   = 'images/eu/europa.jpg';
                $title_header = 'Europa';
                break;
            case 'caribe':
                $img_header   = 'images/eu/caribbean.jpg';
                $title_header = 'The Caribbean & Suth America';
                break;
            default:
                abort(404);
                break;

        }

        $convenio = Convenio::where('llave', $convenio)->select('id', 'llave', 'empresa_nombre', 'welcome')->first();

        session()->put([
            'convenio_nombre' => $convenio->empresa_nombre,
            'convenio_id'     => $convenio->id,
            'welcome'         => $convenio->welcome,
        ]);

        $destinos = Destino::where('top_id', $top)->get();

        return view('pagina.usa.top_destinos', compact('destinos', 'convenio', 'img_header', 'title_header'));
    }

    public function estancias_especiales()
    {

        $destinos_exclusivos = Destino::where('top_id', 'especial')->get();
        // dd($destinos_exclusivos);
        return view('pagina.usa.est_especiales', compact('destinos_exclusivos'));
    }
    public function cotizador()
    {
        return view('pagina.usa.cotizador');
    }

    public function detalle_estancia($slug)
    {
        $destino = Destino::where('slug', $slug)->first();

        $estancias = Estancia::whereHas('destino', function ($q) use ($slug) {
            $q->where('slug', $slug);
        })
            ->where('est_especial', 0)
            ->where('habilitada', 1)
            ->where('estancia_paise_id', env('APP_PAIS_ID', 7))
            ->orderBy('precio', 'asc')
            ->get();

        $hoteles = Hotel::whereHas('destino', function ($q) use ($slug) {
            $q->where('slug', $slug);
        })->get();

        // dd($destino, $estancias);
        return view('pagina.usa.detalle_estancia', compact('estancias', 'hoteles', 'destino'));
    }

    public function buscar_cp($cp, $asenta = null)
    {
        $info = CP::select('id', 'id_municipio', 'id_estado')
            ->where('id_codigo', $cp)
            ->groupBy('id', 'id_municipio', 'id_estado')
            ->limit(1)
            ->get();
        $colonia = CP::select(DB::raw("id,id_asenta AS colonia"))
            ->where('id_codigo', $cp)
            ->get();

        if ($asenta != null) {
            $direccion = CP::select(DB::raw("id,id_asenta AS colonia"))
                ->where('id', $id)
                ->get();
            $rs['direccion'] = $direccion;
        }
        $rs['info']    = $info;
        $rs['colonia'] = $colonia;

        return $rs;
    }

    public function sorteo($convenio)
    {
        $convenio = Convenio::where('llave', $convenio)->first();

        return view('pagina.usa.sorteo', compact('convenio'));
    }

    public function hoteles_amigos()
    {
        return view('pagina.usa.hoteles_amigos');
    }

    public function nosotros()
    {
        return view('pagina.usa.nosotros');
    }

    public function preguntas()
    {
        return view('pagina.usa.preguntas');
    }

    // Exclusive destinatinos
    public function miami($convenio = 'usoptucorp')
    {
        if (session()->exists('llave')) {
            $convenio = session('llave');
        }

        $convenio = Convenio::where('llave', $convenio)->select('id', 'llave', 'empresa_nombre', 'welcome')->first();
        session([
            'convenio_nombre' => $convenio->empresa_nombre,
            'convenio_id'     => $convenio->id,
            'welcome'         => $convenio->welcome,
        ]);

        $estancias = Estancia::whereIn('id', [37576, 37577])->orderBy('id', 'ASC')->get();

        return view('pagina.usa.exclusive.miami', compact('estancias', 'convenio'));
    }

    public function vegasnv($convenio = 'usoptucorp')
    {
        if (session()->exists('llave')) {
            $convenio = session('llave');
        }

        $convenio = Convenio::where('llave', $convenio)->select('id', 'llave', 'empresa_nombre', 'welcome')->first();
        session([
            'convenio_nombre' => $convenio->empresa_nombre,
            'convenio_id'     => $convenio->id,
            'welcome'         => $convenio->welcome,
        ]);

        $estancias = Estancia::whereIn('id', [37578, 37579])->orderBy('id', 'ASC')->get();

        return view('pagina.usa.exclusive.vegas', compact('estancias', 'convenio'));
    }
    public function bahamas($convenio = '')
    {
        if (session()->exists('llave')) {
            $convenio = session('llave');
        }

        $convenio = Convenio::where('llave', $convenio)->select('id', 'llave', 'empresa_nombre', 'welcome')->first();
        session([
            'convenio_nombre' => $convenio->empresa_nombre,
            'convenio_id'     => $convenio->id,
            'welcome'         => $convenio->welcome,
        ]);

        $estancia = Estancia::findOrFail('37680');
        return view('pagina.usa.exclusive.bahamas', compact('estancia', 'convenio'));
    }

    public function puntacana($convenio = 'usoptucorp')
    {

        // dd(session()->all());
        if (session()->exists('llave')) {
            $convenio = session('llave');
        }

        $convenio = Convenio::where('llave', $convenio)->select('id', 'llave', 'empresa_nombre', 'welcome')->first();

        $estancias = Estancia::whereIn('id', [37580, 37581])->get();
        return view('pagina.usa.exclusive.puntacana', compact('estancias', 'convenio'));
    }
    public function cancun($convenio = 'usoptucorp')
    {
        // dd(session()->all());
        if (session()->exists('llave')) {
            $convenio = session('llave');
        }

        $convenio = Convenio::where('llave', $convenio)->select('id', 'llave', 'empresa_nombre', 'welcome')->first();

        $estancias = Estancia::whereIn('id', [37727, 37728])->get();

        return view('pagina.usa.exclusive.cancun', compact('estancias', 'convenio'));
    }
    public function riu_cancun($convenio = 'usoptucorp')
    {

        if (session()->exists('llave')) {
            $convenio = session('llave');
        }

        $convenio = Convenio::where('llave', $convenio)->select('id', 'llave', 'empresa_nombre', 'welcome')->first();
        session([
            'convenio_nombre' => $convenio->empresa_nombre,
            'convenio_id'     => $convenio->id,
            'welcome'         => $convenio->welcome,
        ]);

        $estancia = Estancia::findOrFail('37589');
        return view('pagina.usa.exclusive.riu_cancun', compact('estancia', 'convenio'));
    }
    public function riu_santa_fe($convenio = 'usoptucorp')
    {
        if (session()->exists('llave')) {
            $convenio = session('llave');
        }

        $convenio = Convenio::where('llave', $convenio)->select('id', 'llave', 'empresa_nombre', 'welcome')->first();
        session([
            'convenio_nombre' => $convenio->empresa_nombre,
            'convenio_id'     => $convenio->id,
            'welcome'         => $convenio->welcome,
        ]);

        $estancia = Estancia::findOrFail('37590');
        return view('pagina.usa.exclusive.riu_santa_fe', compact('estancia', 'convenio'));
    }
    public function riu_palace_jamaica($convenio = 'usoptucorp')
    {
        if (session()->exists('llave')) {
            $convenio = session('llave');
        } else {
            $convenio = 'usoptucorp';
        }

        $convenio = Convenio::where('llave', $convenio)->select('id', 'llave', 'empresa_nombre', 'welcome')->first();

        // dd($convenio);
        session([
            'convenio_nombre' => $convenio->empresa_nombre,
            'convenio_id'     => $convenio->id,
            'welcome'         => $convenio->welcome,
        ]);

        $estancia = Estancia::findOrFail('37681');

        return view('pagina.usa.exclusive.riu_palace_jamaica', compact('estancia', 'convenio'));
    }
    public function riu_palace_riviera($convenio = 'usoptucorp')
    {

        if (session()->exists('llave')) {
            $convenio = session('llave');
        }

        $convenio = Convenio::where('llave', $convenio)->select('id', 'llave', 'empresa_nombre', 'welcome')->first();
        session([
            'convenio_nombre' => $convenio->empresa_nombre,
            'convenio_id'     => $convenio->id,
            'welcome'         => $convenio->welcome,
        ]);
        $estancia = Estancia::findOrFail('37679');

        return view('pagina.usa.exclusive.riu_palace_riviera', compact('estancia', 'convenio'));
    }
    public function hawai($convenio = 'usoptucorp')
    {

        if (session()->exists('llave')) {
            $convenio = session('llave');
        }

        $convenio = Convenio::where('llave', $convenio)->select('id', 'llave', 'empresa_nombre', 'welcome')->first();
        session([
            'convenio_nombre' => $convenio->empresa_nombre,
            'convenio_id'     => $convenio->id,
            'welcome'         => $convenio->welcome,
        ]);

        $estancia = Estancia::findOrFail('37678');
        return view('pagina.usa.exclusive.hawaii', compact('estancia', 'convenio'));
    }

    public function disney_world($convenio = 'usoptucorp')
    {
        if (session()->exists('llave')) {
            $convenio = session('llave');
        }

        $convenio = Convenio::where('llave', $convenio)->select('id', 'llave', 'empresa_nombre', 'welcome')->first();
        session([
            'convenio_nombre' => $convenio->empresa_nombre,
            'convenio_id'     => $convenio->id,
            'welcome'         => $convenio->welcome,
        ]);

        $estancias = Estancia::whereIn('id', [37708, 37707, 37706, 37705])->orderBy('id', 'Desc')->get();
        return view('pagina.usa.exclusive.disney_world', compact('estancias', 'convenio'));
    }

    public function get_info_estancia($id)
    {
        $estancia = Estancia::findOrFail($id);
        return response()->json($estancia->descripcion);
    }
}
