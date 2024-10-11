<?php

namespace App\Http\Livewire\Reportes;

use Livewire\Component;
use App\User;
use App\Contrato;
use DB;
use Livewire\WithPagination;

class Clientes extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $users = [];
    public $estatus_con = 'comprado';

    public function mount()
    {
    }

    public function changeEstatus($estatus)
    {
        $this->estatus_con = $estatus;
    }

    public function render()
    {

        $contratos = Contrato::where('estatus', $this->estatus_con)   
            ->whereHas('convenio', function($query){
                return $query->where('paise_id', config('app.pais_id'));
            })->paginate(15);
        
        $contratos_estatus = Contrato::select(DB::raw('count(id) as num_clientes'), 'estatus')
            ->whereHas('cliente', function($query){
                return $query->where('role', 'client');
            })
            ->whereHas('convenio', function($query){
                return $query->where('paise_id', config('app.pais_id'));
            })
            ->groupBy('estatus')->orderBy('num_clientes','DESC')->get();

        return view('livewire.reportes.clientes', compact('contratos', 'contratos_estatus'));
    }
}
