<?php

namespace App\Http\Livewire\Bases;

use App\Contrato;
use App\User;
use Livewire\Component;

class Index extends Component
{
    public $fecha_inicio, $fecha_fin, $ejecutivos_select, $estatus;

    public function render()
    {
        $ejecutivos        = User::whereIn('role', ['sales', 'supervisor'])->get();
        $estatus_contratos = Contrato::groupBy('estatus')->get('estatus');
        return view('livewire.bases.index', compact('ejecutivos', 'estatus_contratos'));
    }

    public function getFiltrado()
    {
        dd($this->fecha_inicio, $this->fecha_fin, $this->ejecutivos_select, $this->estatus);
        $validacionData = $this->validate([
            'fecha_inicio' => 'required | date',
            'fecha_fin'    => 'required | date',
        ]);
        $estatus  = $this->estatus;
        $filtrado = Contrato::with(['cliente', 'estancia', 'padre', 'convenio'])
            ->when($this->estatus[0] != 'all', function ($query) {
                return $query->whereIn('estatus', $this->estatus);
            })
            ->when($this->ejecutivos_select[0] != 'all', function ($query) {
                return $query->whereHas('padre', function ($q) {
                    return $q->whereIn('title', $this->ejecutivos_select);
                });
                // return $query->whereIn('estatus', $this->ejecutivos_select);
            })
            ->whereBetween('created', [$this->fecha_inicio, $this->fecha_fin])
            ->groupBy('user_id')
            ->get();

        dd($filtrado);
    }
}
