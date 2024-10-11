<?php

namespace App\Http\Livewire\Ajustes;

use Livewire\Component;
use DB;
use Livewire\WithPagination;

class Queue extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $title = ''; 
    public $visible = false;
    

    public function mount()
    {
        $this->emit('recargarDatos', 'recargarDatos');
    }


    public function render()
    {
        $jobs = DB::table('jobs')->paginate(10);
    
        if (count($jobs) != 0) {
            $this->visible = true;
            $this->title = 'Colas en ejecución'; 
        }else{
            $this->visible = false;
            $this->title = 'No hay colas pendientes a ejecución';
        }
        
        return view('livewire.ajustes.queue', compact('jobs'));
    }
}
