<?php

namespace App\Http\Livewire\Respaldos;

use Livewire\Component;
use App\Imagen;
use Livewire\WithPagination;


class Calidades extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    // public $respaldos;

    public function render()
    {
        $respaldos = Imagen::where('model','Contrato')->paginate(10);
        // dd($respaldos);
        return view('livewire.respaldos.calidades', compact('respaldos'));
    }
}
