<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use Auth;
use App\Padre;
use App\Contrato;
use App\User;
use Excel;
use App\Exports\ClientesEjecutivoExport;

class ClientesEjecutivo extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $user_id;
    public $paginate = 10;
    public $username, $padre_id;
    public $fecha_inicio, $fecha_fin, $estatus_folio;
    public function render()
    {
        $user = User::findOrFail($this->user_id);
        $this->username = $user->username;
        if (isset($this->user_id)) {
            $this->padre_id = Padre::where('user_id', $this->user_id)->first()->id;
        } else {
            $this->padre_id = Padre::where('user_id', Auth::user()->id)->first()->id;
        }

        $est = $this->estatus_folio;

        $contratos = Contrato::with('cliente')
        ->where('padre_id', $this->padre_id)
        ->when($this->estatus_folio, function($query){
            return $query->whereIn('estatus',[$this->estatus_folio]);
        })
        ->groupBy('user_id')
        ->paginate($this->paginate);

        $estatus = Contrato::groupBy('estatus')->get(['estatus']);
        return view('livewire.user.clientes-ejecutivo', compact('user', 'contratos', 'estatus'));
    }


    public function downloadExcel()
    {
        $contratos = Contrato::with('cliente')
            ->where('padre_id', $this->padre_id)
            ->when($this->estatus_folio, function($query){
                return $query->whereIn('estatus',[$this->estatus_folio]);
            })
            ->groupBy('user_id')
            ->get();

        return Excel::download(new ClientesEjecutivoExport($contratos), 'Clientes-'.$this->username .'-'. date('Ymd') . '.xls');
    }
}
