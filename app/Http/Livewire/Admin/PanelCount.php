<?php

namespace App\Http\Livewire\Admin;

use App\Contrato;
use App\Pago;
use App\User;
use Livewire\Component;

class PanelCount extends Component
{

    public $type, $route, $icon, $total, $title, $color;

    public function mount($type)
    {
        $this->type = $type;

        switch ($type) {
            case 'por_autorizar':
                $this->contratos_por_autorizar();
                break;
            case 'ventas_hoy':
                $this->ventas_hoy();
                break;
            case 'clientes':
                $this->clientes();
                break;
            case 'ingresos':
                $this->ingresos();
                break;
        }

    }

    public function contratos_por_autorizar()
    {
        $this->total = Contrato::whereHas('convenio', function ($q) {
            $q->where('paise_id', env('APP_PAIS_ID'));
        })->where('estatus', 'por_autorizar')->count();

        $this->route = route('contratos.listar_contratos');
        $this->icon  = 'fas fa-file-pdf';
        $this->title = 'Contratos  por autorizar';
        $this->color = 'round-info';
    }

    public function ventas_hoy()
    {
        $this->total = Contrato::whereHas('convenio', function ($q) {
            $q->where('paise_id', env('APP_PAIS_ID'));
        })->where('created', '>=', date('Y-m-d'))->count();

        $this->route = route('ventas');
        $this->icon  = 'fas fa-file-pdf';
        $this->title = 'Ventas hoy';
        $this->color = 'round-warning';
    }

    public function clientes()
    {
        $this->total = $users = User::whereHas('convenio', function ($q) {
            $q->where('paise_id', env('APP_PAIS_ID'));
        })->where('created', '>=', date('Y-m-d'))->where('role', 'client')->count();

        $this->route = '#';
        $this->icon  = 'fas fa-users';
        $this->title = 'Clientes registrados hoy';
        $this->color = 'round-primary';
    }

    public function ingresos()
    {
        $total = Pago::where('estatus', 'Pagado')
            ->where('fecha_de_pago', date('Y-m-d'))
            ->sum('cantidad');
        $this->total = number_format($total, 2);
        $this->route = '#';
        $this->icon  = 'fas fa-dollar';
        $this->title = 'Ingresos hoy';
        $this->color = 'round-success';
    }

    public function render()
    {
        return view('livewire.admin.panel-count');
    }
}
