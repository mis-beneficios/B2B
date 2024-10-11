<?php

namespace App\Http\Livewire\Cobranza;

use Illuminate\Http\Request;
use Livewire\Component;
use App\Convenio;
use App\Pais;
use Livewire\WithPagination;
use DB;
use Carbon\Carbon;
use App\Tarjeta; 
use App\Pago;
use App\Contrato;
class Terminal extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $titulo = 'Terminal 3.0 Livewire';

    public $fecha_inicio;
    public $fecha_fin;
    
    public $nomina = false;
    public $terminal = false;
    public $viaserfin = true;

    public $pagosRechazados = false;
    public $pagosPagados = false;
    public $pagosPendientes = true;
    public $pagosAnomalías = false;

    public $tipo_tarjeta, $paise_id, $convenio_id;

    public $estatus = [];

    public $segmentos; 

    public $unlock = false;
    private $unlock_key = "Travel#21";
    public $pass_key = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }
    

    public function unlock()
    {
        dd($this->pass_key);
    }

 
    public function render()
    { 
        if ($this->pagosRechazados == true) {
            $this->estatus[] = 'Rechazado';
        }
        if ($this->pagosPagados == true) {
            $this->estatus[] = 'Pagado';
        }
        if ($this->pagosPendientes == true) {
            $this->estatus[] = 'Por Pagar';
        }
        if ($this->pagosAnomalías == true) {
            $this->estatus[] = 'Anomalia';
        }

        $data = DB::table('pagos as p')
        ->join('contratos as con', 'p.contrato_id', '=', 'con.id')
        ->join('users as u', 'con.user_id', '=', 'u.id')
        ->join('convenios as conv', 'u.convenio_id', '=', 'conv.id')
        // ->join('tarjetas as t','con.tarjeta_id', '=', 't.id')
        // ->join('bancos as b','t.banco_id', '=', 'b.id')
        ->select('p.*','con.id as contrato_id', 'con.user_id', 
            'con.tarjeta_id', 'con.via_serfin', 'con.pago_con_nomina',
            'con.estatus as estatus_contrato', 'con.convenio_id', 'con.precio_de_compra', 
            'con.sys_key', 'con.divisa', DB::raw('concat(u.nombre, " ", u.apellidos) as cliente'),
            'conv.empresa_nombre',
            'u.id as user_id',
            'con.tarjeta_id as tarjeta_id'
        );
        $data->whereIn('con.estatus', ['viajado', 'comprado', 'Comprado'])->where('p.cantidad', '>', 0);

        if ($this->nomina && $this->terminal && !$this->viaserfin) {
            // $data->where(['con.pago_con_nomina' => 1, 'con.via_serfin' => 0]);
            $data->where('con.pago_con_nomina', 1)->orwhere('con.via_serfin', 0);
        } elseif ($this->nomina && !$this->terminal && $this->viaserfin) {
            // $data->where(['con.pago_con_nomina' => 1, 'con.via_serfin' => 1]);
            $data->where('con.pago_con_nomina', 1)->orWhere('con.via_serfin', 1);
        
        } elseif ($this->nomina && !$this->terminal && !$this->viaserfin) {
            $data->where('con.pago_con_nomina', 1);
        
        } elseif (!$this->nomina && !$this->terminal && $this->viaserfin) {
            $data->where('con.via_serfin', 1)->where('con.sys_key', '<>', null);
        
        } elseif (!$this->nomina && $this->terminal && !$this->viaserfin) {
            $data->where(['con.pago_con_nomina' => 0, 'con.via_serfin' => 0]);
        
        } elseif (!$this->nomina && $this->terminal && $this->viaserfin) {
            $data->where('con.pago_con_nomina', 0);
        
        } elseif (!$this->nomina && !$this->terminal && !$this->viaserfin) {
            $data->where(['con.pago_con_nomina' => 1, 'con.via_serfin' => 1]);
        }
        
        $data->whereIn('p.estatus', $this->estatus);
    
        if ($this->convenio_id) {
            $data->whereIn('conv.id', $this->convenio_id);
        }
        if ($this->paise_id) {
            $data->where('conv.paise_id', $this->paise_id);
        }
        $data->whereBetween('p.fecha_de_cobro', [$this->fecha_inicio, $this->fecha_fin]);
        $res = $data->paginate(15);



        $data = array();
        $sfr                 = '';
        $index = 1;
        foreach ($res as $pago) {

            $pagos_contrato = Pago::where('contrato_id', $pago->contrato_id)->where('cantidad' , '!=' ,0)->get();
            /**
             * Obtenemos la tarjeta asociada al contrato
             */
            if ($pago->tarjeta_id) {
                $tarjeta = Tarjeta::where('id', $pago->tarjeta_id)->first();
                $tarjeta_info = "<span>".$tarjeta->numeroTarjeta."</span><br><small>". $tarjeta->vence ." | ". $tarjeta->verCvv ."</small><br><small>".$tarjeta->tipo." | ".$tarjeta->r_banco->title."</small>";
            }else{
                $tarjeta_info = "<span> N/A </span>";
            }            

            $segmentos = '<div class="text-justify">';
            foreach ($pagos_contrato as $cp) {
                switch ($cp->estatus) {
                  case 'Pagado':
                      $class = 'btn-success';
                      break;
                  case 'Rechazado':
                      $class = 'btn-danger';
                      break;
                  default:
                      $class = 'btn-inverse';
                      break;
                }      
                $active = ($cp->id == $pago->id) ? ' active' : '';
                $segmentos .= '<button class="mytooltip btn btn-xs btnsmall '.$class . $active .'" id="statusPago'.$cp->id.'"><span class="tooltip-item">'.$cp->segmento.'</span> <span class="tooltip-content clearfix"><span class="tooltip-text">'.$cp->segmento .' | '. $cp->fecha_de_cobro .' | '. number_format($cp->cantidad,2,'.','') .'</span></span></button>';
            }
            $segmentos .= '</div>';

            switch ($pago->estatus) {
                case 'Pagado':
                    $class = 'success';
                    break;
                case 'Rechazado':
                    $class = 'danger';
                    break;
                case 'Anomalias':
                    $class = 'info';
                    break;
                default:
                    $class = 'inverse';
                    break;
            }
            
            $btn = '<button class="btn btn-success btn-xs mr-1" value="' . $pago->id . '" data-pago_id="' . $pago->id . '" data-contrato_id="' . $pago->contrato_id . '" id="btnEditarPago" type="button"><i class="fas fa-edit"></i></button>';
            $btn .= '<button class="btn btn-info btn-xs mr-1" data-pago_id="' . $pago->id . '" data-tarjeta_id="' . '' . '" data-contrato_id="' . $pago->contrato_id . '" id="btnMetodoPago" data-route="' . route('contrato.show_metodo_pago', $pago->contrato_id) . '" type="button"><i class="fas fa-arrows-alt-h"></i></button>';

            // $btn .= '<button class="btn btn-dark btn-xs" data-pago_id="' . $pago->id . '" data-tarjeta_id="' . '' . '" data-contrato_id="' . $pago->contrato_id . '" id="btnUpdate" type="button"><i class="fas fa-cog"></i></button>';


            $data[] = array(
                "1" => '<span class="text-capitalize"><button type="button" id="btnPago" data-pago_id="' . $pago->id . '"  data-index="' . $index . '" data-user_id="' . $pago->user_id . '"  data-contrato_id="' . $pago->contrato_id . '" class="btn btn-dark btn-xs">Segmento: ' . $pago->segmento . '</button> </span><br/><small>' . $pago->id . ' </small>',

                "2" => '<span><a class="" href="' . route('users.show', $pago->user_id) . '" target="_blank">' . $pago->cliente . ' </a> <br>' . $pago->empresa_nombre . '</span><br>',
                
                "3" => '<span id="cantidadPago'.$pago->id.'">' . $pago->divisa .number_format($pago->cantidad, 2) . '</span><br/><small>De: ' . $pago->divisa . number_format($pago->precio_de_compra, 2) . ' </small>',

                "4" => '<button class="btn btn-xs btn-' . $class . '  btnMostratPagos estatusPago' . $pago->id . '"  data-id="all"  id="estatusPago' . $pago->id . '" value="' . $pago->contrato_id . '">' . $pago->estatus . '</button><br/><small>'.$this->obtener_serfin($pago->id).' </small>',

                "5" => '<span id="fechaCobro'.$pago->id.'">' . $pago->fecha_de_cobro . '</span><br/><small id="fechaPago'.$pago->id.'">' . $pago->fecha_de_pago . ' </small>',
                
                "6" => $btn,

                "7" => '<span><a class="" href="' . route('users.show', $pago->user_id) . '" target="_blank"> # ' . $pago->contrato_id . ' </a><br/>' . $pago->sys_key . '</span>',
                "8" => $tarjeta_info,
                "9" => $segmentos,
            );
            $btn = '';
            $index++;
        }

        $paises    = Pais::select('id', 'title')->get();
        $convenios = Convenio::select('id', 'empresa_nombre')->where('paise_id', 1)->get(); 

        return view('livewire.cobranza.terminal', compact('paises','convenios', 'data','res'));
    }


    public function obtener_serfin($pago)
    {
        $pago = Pago::findOrFail($pago);
        $sfr = '';
        $sfr .= '<ul class="list-unstyled" style="font-size:10px;">';
        if ($pago->concepto == 'Enganche') {
            $sfr .= '<li>' . $pago->concepto . '</li>';
        }
        if ($pago->created_by) {
            $sfr .= '<li> Creado por: ' . $pago->created_by . '</li>';
        }
        foreach ($pago->historial_desc as $key => $historial) {
            $sfr .= '<li>' . $historial->motivo_del_rechazo . '</li>';
        }
        $sfr .= '</ul>';

        return $sfr;
    }


    public function edit_pago($input = null, $value = null)
    {
       
        
        if ($this->pagosRechazados == true) {
            $estatus[] = 'Rechazado';
        }
        if ($this->pagosPagados == true) {
            $estatus[] = 'Pagado';
        }
        if ($this->pagosPendientes == true) {
            $estatus[] = 'Por Pagar';
        }
        if ($this->pagosAnomalías == true) {
            $estatus[] = 'Anomalia';
        }

        $res = Pago::with(['contrato.cliente','tarjeta'])
            // ->whereHas('contrato.convenio', function($query){
            //     if ($this->convenio_id) {
            //         $query->whereIn('id', $this->convenio_id);
            //     }
            // })
            // ->whereHas('contrato', function($query){
            //     if ($this->nomina && $this->terminal && !$this->viaserfin) {
            //         // $data->where(['con.pago_con_nomina' => 1, 'con.via_serfin' => 0]);
            //         $query->where('pago_con_nomina', 1)->orwhere('via_serfin', 0);
            //     } elseif ($this->nomina && !$this->terminal && $this->viaserfin) {
            //         // $query->where(['pago_con_nomina' => 1, 'via_serfin' => 1]);
            //         $query->where('pago_con_nomina', 1)->orWhere('via_serfin', 1);
                
            //     } elseif ($this->nomina && !$this->terminal && !$this->viaserfin) {
            //         $query->where('pago_con_nomina', 1);
                
            //     } elseif (!$this->nomina && !$this->terminal && $this->viaserfin) {
            //         $query->where('via_serfin', 1)->where('sys_key', '<>', null);
                
            //     } elseif (!$this->nomina && $this->terminal && !$this->viaserfin) {
            //         $query->where(['pago_con_nomina' => 0, 'via_serfin' => 0]);
                
            //     } elseif (!$this->nomina && $this->terminal && $this->viaserfin) {
            //         $query->where('pago_con_nomina', 0);
                
            //     } elseif (!$this->nomina && !$this->terminal && !$this->viaserfin) {
            //         $query->where(['pago_con_nomina' => 1, 'via_serfin' => 1]);
            //     }

            //     $query->whereIn('estatus', ['viajado', 'comprado', 'Comprado']);
            // })

            ->where('cantidad', '>', 0)
            ->whereIn('estatus', $estatus)
            ->whereBetween('fecha_de_cobro', [$this->fecha_inicio, $this->fecha_fin])
            ->paginate(15);
            dd($res);
    }



    public function pintar_terminal($value='')
    {
         $data = DB::table('pagos as p')
        ->join('contratos as con', 'p.contrato_id', '=', 'con.id')
        ->join('users as u', 'con.user_id', '=', 'u.id')
        ->join('convenios as conv', 'u.convenio_id', '=', 'conv.id')
        // ->join('tarjetas as t','con.tarjeta_id', '=', 't.id')
        // ->join('bancos as b','t.banco_id', '=', 'b.id')
        ->select('p.*','con.id as contrato_id', 'con.user_id', 
            'con.tarjeta_id', 'con.via_serfin', 'con.pago_con_nomina',
            'con.estatus as estatus_contrato', 'con.convenio_id', 'con.precio_de_compra', 
            'con.sys_key', 'con.divisa', DB::raw('concat(u.nombre, " ", u.apellidos) as cliente'),
            'conv.empresa_nombre',
            'u.id as user_id',
            'con.tarjeta_id as tarjeta_id'
        );
        $data->whereIn('con.estatus', ['viajado', 'comprado', 'Comprado'])->where('p.cantidad', '>', 0);

        if ($this->nomina && $this->terminal && !$this->viaserfin) {
            // $data->where(['con.pago_con_nomina' => 1, 'con.via_serfin' => 0]);
            $data->where('con.pago_con_nomina', 1)->orwhere('con.via_serfin', 0);
        } elseif ($this->nomina && !$this->terminal && $this->viaserfin) {
            // $data->where(['con.pago_con_nomina' => 1, 'con.via_serfin' => 1]);
            $data->where('con.pago_con_nomina', 1)->orWhere('con.via_serfin', 1);
        
        } elseif ($this->nomina && !$this->terminal && !$this->viaserfin) {
            $data->where('con.pago_con_nomina', 1);
        
        } elseif (!$this->nomina && !$this->terminal && $this->viaserfin) {
            $data->where('con.via_serfin', 1)->where('con.sys_key', '<>', null);
        
        } elseif (!$this->nomina && $this->terminal && !$this->viaserfin) {
            $data->where(['con.pago_con_nomina' => 0, 'con.via_serfin' => 0]);
        
        } elseif (!$this->nomina && $this->terminal && $this->viaserfin) {
            $data->where('con.pago_con_nomina', 0);
        
        } elseif (!$this->nomina && !$this->terminal && !$this->viaserfin) {
            $data->where(['con.pago_con_nomina' => 1, 'con.via_serfin' => 1]);
        }
        
        $data->whereIn('p.estatus', $estatus);
    
        if ($this->convenio_id) {
            $data->whereIn('conv.id', $this->convenio_id);
        }
        if ($this->paise_id) {
            $data->where('conv.paise_id', $this->paise_id);
        }
        $data->whereBetween('p.fecha_de_cobro', [$this->fecha_inicio, $this->fecha_fin]);
        $res = $data->paginate(15);



        $data = array();
        $sfr                 = '';
        $index = 1;
        foreach ($res as $pago) {

            $pagos_contrato = Pago::where('contrato_id', $pago->contrato_id)->where('cantidad' , '!=' ,0)->get();
            /**
             * Obtenemos la tarjeta asociada al contrato
             */
            if ($pago->tarjeta_id) {
                $tarjeta = Tarjeta::where('id', $pago->tarjeta_id)->first();
                $tarjeta_info = "<span>".$tarjeta->numeroTarjeta."</span><br><small>". $tarjeta->vence ." | ". $tarjeta->verCvv ."</small><br><small>".$tarjeta->tipo." | ".$tarjeta->r_banco->title."</small>";
            }else{
                $tarjeta_info = "<span> N/A </span>";
            }            

            $segmentos = '<div class="text-justify">';
            foreach ($pagos_contrato as $cp) {
                switch ($cp->estatus) {
                  case 'Pagado':
                      $class = 'btn-success';
                      break;
                  case 'Rechazado':
                      $class = 'btn-danger';
                      break;
                  default:
                      $class = 'btn-inverse';
                      break;
                }      
                $active = ($cp->id == $pago->id) ? ' active' : '';
                $segmentos .= '<button class="mytooltip btn btn-xs btnsmall '.$class . $active .'" id="statusPago'.$cp->id.'"><span class="tooltip-item">'.$cp->segmento.'</span> <span class="tooltip-content clearfix"><span class="tooltip-text">'.$cp->segmento .' | '. $cp->fecha_de_cobro .' | '. number_format($cp->cantidad,2,'.','') .'</span></span></button>';
            }
            $segmentos .= '</div>';

            switch ($pago->estatus) {
                case 'Pagado':
                    $class = 'success';
                    break;
                case 'Rechazado':
                    $class = 'danger';
                    break;
                case 'Anomalias':
                    $class = 'info';
                    break;
                default:
                    $class = 'inverse';
                    break;
            }
            
            $btn = '<button class="btn btn-success btn-xs mr-1" value="' . $pago->id . '" data-pago_id="' . $pago->id . '" data-contrato_id="' . $pago->contrato_id . '" id="btnEditarPago" type="button"><i class="fas fa-edit"></i></button>';
            $btn .= '<button class="btn btn-info btn-xs mr-1" data-pago_id="' . $pago->id . '" data-tarjeta_id="' . '' . '" data-contrato_id="' . $pago->contrato_id . '" id="btnMetodoPago" data-route="' . route('contrato.show_metodo_pago', $pago->contrato_id) . '" type="button"><i class="fas fa-arrows-alt-h"></i></button>';

            // $btn .= '<button class="btn btn-dark btn-xs" data-pago_id="' . $pago->id . '" data-tarjeta_id="' . '' . '" data-contrato_id="' . $pago->contrato_id . '" id="btnUpdate" type="button"><i class="fas fa-cog"></i></button>';


            $data[] = array(
                "1" => '<span class="text-capitalize"><button type="button" id="btnPago" data-pago_id="' . $pago->id . '"  data-index="' . $index . '" data-user_id="' . $pago->user_id . '"  data-contrato_id="' . $pago->contrato_id . '" class="btn btn-dark btn-xs">Segmento: ' . $pago->segmento . '</button> </span><br/><small>' . $pago->id . ' </small>',

                "2" => '<span><a class="" href="' . route('users.show', $pago->user_id) . '" target="_blank">' . $pago->cliente . ' </a> <br>' . $pago->empresa_nombre . '</span><br>',
                
                "3" => '<span id="cantidadPago'.$pago->id.'">' . $pago->divisa .number_format($pago->cantidad, 2) . '</span><br/><small>De: ' . $pago->divisa . number_format($pago->precio_de_compra, 2) . ' </small>',

                "4" => '<button class="btn btn-xs btn-' . $class . '  btnMostratPagos estatusPago' . $pago->id . '"  data-id="all"  id="estatusPago' . $pago->id . '" value="' . $pago->contrato_id . '">' . $pago->estatus . '</button><br/><small>'.$this->obtener_serfin($pago->id).' </small>',

                "5" => '<span id="fechaCobro'.$pago->id.'">' . $pago->fecha_de_cobro . '</span><br/><small id="fechaPago'.$pago->id.'">' . $pago->fecha_de_pago . ' </small>',
                
                "6" => $btn,

                "7" => '<span><a class="" href="' . route('users.show', $pago->user_id) . '" target="_blank"> # ' . $pago->contrato_id . ' </a><br/>' . $pago->sys_key . '</span>',
                "8" => $tarjeta_info,
                "9" => $segmentos,
            );
            $btn = '';
            $index++;
        }

    }
}
