<?php

namespace App\Http\Livewire\Actividad;

use App\Actividad;
use Carbon\Carbon;
use DB;
use Livewire\Component;

class ListarEjecutivos extends Component
{
    // public $ejecutivos;
    // public $seguimientos;
    // public $actividadesEmpresaList;
    public $actividades;
    public $fecha;
    public $ver_empresas            = false;
    public $ver_actividades         = false;
    public $ver_actividades_empresa = false;
    public $div_empresas;
    public $user_id;
    public $concal_id;

    public function mount()
    {
        $this->div_empresas = 'col-lg-4 col-md-4';
        $this->fecha        = Carbon::now()->format('Y-m-d');
    }
    public function render()
    {

        $ejecutivos = DB::table('users')
            ->select('users.id as id', DB::raw("UPPER(CONCAT(users.nombre,' ',users.apellidos)) AS nombre"), DB::raw("count(distinct actividades.id) AS actividades"), DB::raw("count(distinct concals.id) as empresas"))
            ->leftJoin('actividades', function ($join) {
                $join->on('users.id', '=', 'actividades.user_id')
                    ->whereDate("actividades.created_at", $this->fecha);
            })
            ->leftJoin('concals', function ($join) {
                $join->on('users.id', '=', 'concals.user_id')
                    ->whereDate('concals.created', $this->fecha);
            })
            ->where('users.actividades', '=', 1)
            ->whereIn('users.role', ['conveniant'])
            ->where('users.permitir_login', '=', 1)
            ->groupBy('users.id', 'users.nombre')
            ->orderBy('nombre')
            ->orderBy('id')
            ->get();

        $seguimientos = DB::table('concals')->where('user_id', $this->user_id)->whereDate('created', $this->fecha)->orderBy('id', 'DESC')->get();

        $actividadesEmpresaList = Actividad::where('concal_id', $this->concal_id)->whereDate('created_at', $this->fecha)->orderBy('created_at', 'DESC')->get();

        return view('livewire.actividad.listar-ejecutivos', compact('ejecutivos', 'seguimientos', 'actividadesEmpresaList'));
    }

    public function listarEmpresas($id, $tipo)
    {
        $this->user_id = $id;
        if ($tipo == 0) {
            $this->ver_empresas    = true;
            $this->ver_actividades = false;
        }
        $this->ver_actividades_empresa = false;
    }

    public function listarActividades($id, $tipo)
    {
        $this->div_empresas    = 'col-lg-9 col-md-7';
        $this->ver_empresas    = false;
        $this->ver_actividades = true;
        $this->actividades     = Actividad::where('user_id', $id)->whereDate('created_at', $this->fecha)->orderBy('concal_id')->orderBy('id', 'DESC')->get();

    }

    public function actividadesEmpresa($id)
    {
        $this->concal_id               = $id;
        $this->ver_actividades_empresa = true;
        $this->div_empresas            = 'col-lg-4 col-md-4';
    }

}
