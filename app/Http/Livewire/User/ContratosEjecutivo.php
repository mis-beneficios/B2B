<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use Auth;
use App\Padre;
use App\Contrato;
use App\User;
use Excel;
use App\Exports\ContratosEjecutivoExport;
class ContratosEjecutivo extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $user_id;
    public $paginate = 10;
    public $username, $padre_id;

    public function render()
    {
        $user = User::findOrFail($this->user_id);
        $this->username = $user->username;
        if (isset($this->user_id)) {
            $this->padre_id = Padre::where('user_id', $this->user_id)->first()->id;
        } else {
            $this->padre_id = Padre::where('user_id', Auth::user()->id)->first()->id;
        }

        $contratos = Contrato::with('cliente')
        ->where('padre_id', $this->padre_id)
        ->paginate($this->paginate);

        return view('livewire.user.contratos-ejecutivo', compact('user', 'contratos'));
    }


    public function downloadExcel()
    {
        $contratos = Contrato::with('cliente')
            ->where('padre_id', $this->padre_id)
            ->get();

        return Excel::download(new ContratosEjecutivoExport($contratos), 'Contratos-'.$this->username .'-'. date('Ymd') . '.xls');
    }
}
