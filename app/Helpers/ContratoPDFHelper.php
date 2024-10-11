<?php

namespace App\Helpers;

use App;
use App\Contrato;
use App\Convenio;
use App\Estancia;

class ContratoPDFHelper
{

    /**
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-10-03
     * Obtenemos los datos para mostrar el contrato en texto plano
     * @param  [int] $id [description]
     * @return [json] contrato texto plano
     */
    public function mostrar_contrato($id)
    {
        $con = Contrato::findOrFail($id);

        $contrato = $this->procesar_datos_contrato($con);
        $formato  = $this->construir_contrato($contrato, $con);
        $name     = 'C' . $con->id . '.pdf';
        $path     = public_path() . '/files/contratos_usa/' . $name;
        $pdf      = App::make('dompdf.wrapper');
        $pdf->loadHTML($formato);
        $pdf->save($path);

        $res['formato'] = $formato;
        $res['name']    = '/files/contratos_mx/' . $name;
        return $res;
    }

    /**
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-10-03
     * Obtenermos el contrato y se convierte en pdf almacenandolo en la ruta de contratos_usa para mandar el archivo adjunto en el emial
     * @param  [int] $id
     * @return [string] nombre del archivo pdf
     */
    public function obtener_contrato_pdf($id)
    {
        $con      = Contrato::findOrFail($id);
        $contrato = $this->procesar_datos_contrato($con);
        $formato  = $this->construir_contrato($contrato, $con);

        $name = 'C' . $con->id . '.pdf';
        $path = public_path() . '/files/contratos_usa/' . $name;
        $pdf  = App::make('dompdf.wrapper');
        $pdf->loadHTML($formato);
        $pdf->save($path);

        return $name;
    }

    /**
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-10-03
     * Sustitucion de las llaves definidas en el contrato con los datos del contrato para construir el contrato en texto plano
     * @param  [array] $emailVars ]
     * @param  [array] $contrato
     * @return [string] contrato texto plano
     */
    public function construir_contrato($emailVars, $contrato)
    {

        if ($contrato['Estancia']['descripcion_formal_es_contrato_completo'] == false) {
            if ($contrato['pago_con_nomina']) {
                $contrato_cuerpo = $contrato['Convenio']['contrato_nomina'];
            } else {
                $contrato_cuerpo = $contrato['Convenio']['contrato'];
            }
        } else {
            $contrato_cuerpo = $contrato['Estancia']['descripcion_formal'];
            $contrato_cuerpo = str_replace('[estancia]', '', $contrato_cuerpo);
            $contrato_cuerpo = str_replace(' noches Temporada: ______________________<br>', '<br>', $contrato_cuerpo);
        }

        for ($i = 2; $i >= 1; $i--) {
            foreach ($emailVars as $var => $data) {
                $contrato_cuerpo = str_replace('[' . $var . ']', $data, $contrato_cuerpo);
            }
        }
        return $contrato_cuerpo;
    }

    /**
     * Autor:  Isw. Diego Enrique Sanchez
     * Creado: 2021-10-03
     * Descarga el archivo almacenado en formato PDF
     * @param  [int] $id
     * @return stream del contrato
     */
    public function descargar_contrato($id)
    {
        $con      = Contrato::findOrFail($id);
        $contrato = $this->procesar_datos_contrato($con);
        $formato  = $this->construir_contrato($contrato, $con);

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($formato);
        $pdf->download('C' . $con->id . '.pdf');
        return $pdf->stream('C' . $con->id . '.pdf');
    }

    /**
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-10-03
     * Reemplazo de los datos en las llaves que seran reemplazadas en el formato del contrato
     * @param  [objeti] $contratoData
     * @return [array] todos los valos reemplazados por su llave
     */
    public function procesar_datos_contrato($contratoData)
    {

        $emailVars = array();

        //Acerca del Contrato
        $emailVars['contrato_id']       = $contratoData->id;
        $emailVars['fecha_de_contrato'] = (count($contratoData->pagos_contrato) > 0) ? $contratoData->pagos_contrato[0]->fecha_de_cobro : ': pendiente';
        $emailVars['first-installment'] = (count($contratoData->pagos_contrato) > 0) ? $contratoData->pagos_contrato[0]->fecha_de_cobro : ': pendiente';
        $emailVars['fechadecontrato']   = $emailVars['fecha_de_contrato'];
        $emailVars['fecha-de-contrato'] = $contratoData->created;

        // $emailVars['nombre_hotel']   = $contratoData['Hotel']['nombre'];
        $emailVars['nombre_destino'] = $contratoData->paquete;

        if ((count($contratoData->pagos_contrato) > 0)) {
            if ($contratoData->pagos_contrato[0]->segmento == 0) {
                foreach ($contratoData->pagos_contrato as $pago) {
                    if ($pago->segmento > 0) {
                        $emailVars['fecha_de_contrato'] = $pago->fecha_de_cobro;
                        break;
                    }
                }
            }
        }

        $emailVars['precio_de_compra'] = $contratoData->precio_de_compra . ' ' . $contratoData->divisa;
        $emailVars['preciodecompra']   = $emailVars['precio_de_compra'];
        $emailVars['precio-de-compra'] = $emailVars['precio_de_compra'];

        $emailVars['metodo_de_compra'] = ($contratoData->pago_con_nomina) ? "Nómina" : "Banca";
        $emailVars['metododecompra']   = $emailVars['metodo_de_compra'];
        $emailVars['metodo-de-compra'] = $emailVars['metodo_de_compra'];

        //Arreglo temporal
        switch ($contratoData->paquete) {
            case 'ti':
                $emailVars['dias_noches']    = '3 días 2 noches';
                $emailVars['adultos']        = 2;
                $emailVars['ninos']          = 2;
                $emailVars['edad_max_ninos'] = 12;
                $emailVars['cuotas_title']   = 'MENSUALES';
                break;
            case 'ii':
                $emailVars['dias_noches']    = '5 días 4 noches';
                $emailVars['adultos']        = 2;
                $emailVars['ninos']          = 2;
                $emailVars['edad_max_ninos'] = 12;
                $emailVars['cuotas_title']   = 'MENSUALES';
                break;
            default:
                $noches = $contratoData->noches;
                $dias   = $contratoData->noches + 1;

                $emailVars['dias_noches']      = (isset($contratoData->convenio->paise_id) && $contratoData->convenio->paise_id == 11) ? $contratoData->estancia->temporada : $dias . ' días ' . $noches . ' noches';
                $emailVars['fecha_nacimiento'] = (isset($contratoData->cliente->cumpleanos)) ? $contratoData->cliente->cumpleanos : 'Sin confirmar';
                $emailVars['adultos']          = $contratoData->adultos;
                $emailVars['ninos']            = $contratoData->ninos;
                $emailVars['edad_max_ninos']   = $contratoData->edad_max_ninos;

                $emailVars['cuotas'] = $contratoData->pagos_contrato();
                // $emailVars['cuotas'] = $contratoData->estancia->cuotas;

                // La siguiente linea manda al procesador del envío de contrato el
                // espacio agregado de la descripción formal de la estancia.
                $emailVars['estancia']       = $contratoData->estancia->descripcion_formal;
                $emailVars['estancia_title'] = $contratoData->estancia->title;
                $emailVars['ESTANCIA_TITLE'] = $contratoData->estancia->title;
                $emailVars['noches']         = $contratoData->noches;
                $emailVars['hotel_name']     = $contratoData->estancia->hotel_name;

                switch ($emailVars['cuotas']) {
                    case 48:
                        $emailVars['cuotas_title'] = 'SEMANALES';
                        break;
                    case 24:
                        $emailVars['cuotas_title'] = 'QUINCENALES';
                        break;
                    case 12:
                        $emailVars['cuotas_title'] = 'MENSUALES';
                        break;
                }
        }

        $emailVars['noches']       = $contratoData->noches;
        $emailVars['hotel_name']   = $contratoData->hotel_name;
        $emailVars['edadmaxninos'] = $emailVars['edad_max_ninos'];

        $emailVars['empresa_nombre'] = $contratoData->convenio->empresa_nombre;
        $emailVars['cliente']        = $contratoData->cliente->nombre . ' ' . $contratoData->cliente->apellidos;

        $emailVars['telefono']         = $contratoData->cliente->telefono;
        $emailVars['telefono_casa']    = $contratoData->cliente->telefono_casa;
        $emailVars['telefono_oficina'] = $contratoData->cliente->telefono_oficina;

        $emailVars['ciudad']            = $contratoData->cliente->ciudad . ", " . $contratoData->cliente->provincia;
        $emailVars['city']              = $contratoData->cliente->ciudad;
        $emailVars['estate']            = $contratoData->cliente->provincia;
        $emailVars['e-mail']            = $contratoData->cliente->username;
        $emailVars['codigo_postal']     = $contratoData->cliente->codigo_postal;
        $emailVars['cumpleanos']        = $contratoData->cliente->cumpleanos;
        $emailVars['rfc']               = $contratoData->cliente->RFC;
        $emailVars['direccion_cliente'] = $contratoData->cliente->direccion . " " . $contratoData->cliente->direccion2;

        if ($contratoData->estancia->est_especial == 1) {
            // $emailVars['monto_cuotas_num']  = $contratoData->estancia->precio / $contratoData->estancia->cuotas;
            $emailVars['monto_cuotas_num']  = $contratoData->precio_de_compra / $contratoData->estancia->cuotas;
            $emailVars['monto_cuotas_str']  = $emailVars['monto_cuotas_num'] . ' ' . $contratoData->divisa;
            $emailVars['enganche_especial'] = "A one time only deposit fee for the amount of <strong>" . $contratoData->estancia->enganche_especial . ' ' . $contratoData->divisa . "</strong>, non refundable.";
        } else {
            $emailVars['monto_cuotas_num']  = $contratoData->precio_de_compra / $contratoData->estancia->cuotas;
            $emailVars['monto_cuotas_str']  = $emailVars['monto_cuotas_num'] . ' ' . $contratoData->divisa;
            $emailVars['enganche_especial'] = '';
        }

        /*$emailVars['monto_cuotas_num'] = $contratoData['Contrato']['precio_de_compra'] / $contratoData['Estancia']['cuotas'];
        $emailVars['monto_cuotas_str'] = $text->currency($emailVars['monto_cuotas_num'], $contratoData['Contrato']['divisa']);*/

        // Fin Diego Enrique Sanchez
        switch ($contratoData->noches) {
            case 4:
                $emailVars['dias_noches_usa_str'] = '4 (four) nights and 5 (five) days';
                break;
            default:
                $emailVars['dias_noches_usa_str'] = '2 (two) nights and 3 (three) days';
                break;
        }
        switch ($contratoData->noches) {
            case 4:
                $emailVars['dias_noches_usa_str_v2'] = 'Four (4) Nights';
                break;
            default:
                $emailVars['dias_noches_usa_str_v2'] = 'Two (2) Nights';
                break;
        }

        $emailVars['rym_noches'] = $contratoData->noches;

        return $emailVars;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////  CONTRATOS MX /////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-10-04
     * Obtenemos los datos para mostrar el contrato n texto plano
     * @param  [int] $id [description]
     * @return [json] contrato texto plano
     */
    public function mostrar_contrato_mx($id)
    {
        $con      = Contrato::findOrFail($id);

        if (file_exists(public_path() . '/files/contratos_mx/' . 'C' . $con->id . '.pdf')) {
            unlink(public_path() . '/files/contratos_mx/' . 'C' . $con->id . '.pdf');
        }


        $contrato = $this->procesar_datos_contrato_mx($con);
        $formato  = $this->construir_contrato_mx($contrato, $con);

        // dd($contrato, $formato);
        $name     = 'C' . $con->id . '.pdf';
        $path     = public_path() . '/files/contratos_mx/' . $name;
        $pdf      = App::make('dompdf.wrapper');
        $pdf->loadHTML($formato);
        // $pdf->loadView('admin.contratos.contrato_make', $formato);
        $pdf->save($path);
        $res['formato'] = $formato;
        $res['name']    = '/files/contratos_mx/' . $name;
        return $res;
    }

    /**
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-10-03
     * Obtenermos el contrato y se convierte en pdf almacenandolo en la ruta de contratos_usa para mandar el archivo adjunto en el emial
     * @param  [int] $id
     * @return [string] nombre del archivo pdf
     */
    public function obtener_contrato_pdf_mx($id)
    {
        $con      = Contrato::findOrFail($id);

        if (file_exists(public_path() . '/files/contratos_mx/' . 'C' . $con->id . '.pdf')) {
            unlink(public_path() . '/files/contratos_mx/' . 'C' . $con->id . '.pdf');
        }

        $contrato = $this->procesar_datos_contrato_mx($con);

        $formato = $this->construir_contrato_mx($contrato, $con);

        $name = 'C' . $con->id . '.pdf';
        $path = public_path() . '/files/contratos_mx/' . $name;
        $pdf  = App::make('dompdf.wrapper');
        $pdf->loadHTML($formato);
        $pdf->save($path);

        return $name;
    }

    /**
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-10-03
     * Reemplazo de los datos en las llaves que seran reemplazadas en el formato del contrato
     * @param  [objeti] $contratoData
     * @return [array] todos los valos reemplazados por su llave
     */
    public function procesar_datos_contrato_mx($contratoData)
    {

        $emailVars = array();

        //Acerca del Contrato
        $emailVars['contrato_id']       = $contratoData->id;
        $emailVars['fecha_de_contrato'] = (count($contratoData->pagos_contrato) > 0) ? $contratoData->pagos_contrato[0]->fecha_de_cobro : ': pendiente';
        $emailVars['first-installment'] = (count($contratoData->pagos_contrato) > 0) ? $contratoData->pagos_contrato[0]->fecha_de_cobro : ': pendiente';
        $emailVars['fechadecontrato']   = $emailVars['fecha_de_contrato'];
        $emailVars['fecha-de-contrato'] = $contratoData->created;

        // $emailVars['nombre_hotel']   = $contratoData['Hotel']['nombre'];
        $emailVars['nombre_destino'] = $contratoData->paquete;

        if ((count($contratoData->pagos_contrato) > 0)) {
            if ($contratoData->pagos_contrato[0]->segmento == 0) {
                foreach ($contratoData->pagos_contrato as $pago) {
                    if ($pago->segmento > 0) {
                        $emailVars['fecha_de_contrato'] = $pago->fecha_de_cobro;
                        break;
                    }
                }
            }
        }

        $emailVars['precio_de_compra'] = $contratoData->precio_de_compra . ' ' . $contratoData->divisa;
        $emailVars['preciodecompra']   = $emailVars['precio_de_compra'];
        $emailVars['precio-de-compra'] = $emailVars['precio_de_compra'];

        $emailVars['metodo_de_compra'] = ($contratoData->pago_con_nomina) ? "Nómina" : "Banca";
        $emailVars['metododecompra']   = $emailVars['metodo_de_compra'];
        $emailVars['metodo-de-compra'] = $emailVars['metodo_de_compra'];

        //Arreglo temporal
        switch ($contratoData->paquete) {
            case 'ti':
                $emailVars['dias_noches']    = '3 días 2 noches';
                $emailVars['adultos']        = 2;
                $emailVars['ninos']          = 2;
                $emailVars['edad_max_ninos'] = 12;
                $emailVars['cuotas_title']   = 'MENSUALES';
                break;
            case 'ii':
                $emailVars['dias_noches']    = '5 días 4 noches';
                $emailVars['adultos']        = 2;
                $emailVars['ninos']          = 2;
                $emailVars['edad_max_ninos'] = 12;
                $emailVars['cuotas_title']   = 'MENSUALES';
                break;
            default:
                $noches = $contratoData->noches;
                $dias   = $contratoData->noches + 1;

                $emailVars['dias_noches']      = (isset($contratoData->convenio->paise_id) && $contratoData->convenio->paise_id == 11) ? $contratoData->estancia->temporada : $dias . ' días ' . $noches . ' noches';
                $emailVars['fecha_nacimiento'] = (isset($contratoData->cliente->cumpleanos)) ? $contratoData->cliente->cumpleanos : 'Sin confirmar';
                $emailVars['adultos']          = $contratoData->adultos;
                $emailVars['ninos']            = $contratoData->ninos;
                $emailVars['edad_max_ninos']   = $contratoData->edad_max_ninos;

                if (count($contratoData->cuotas_contrato) != 0) {
                    $emailVars['cuotas'] = count($contratoData->cuotas_contrato);
                } else {
                    $emailVars['cuotas'] = $contratoData->estancia->cuotas;
                }
                // La siguiente linea manda al procesador del envío de contrato el
                // espacio agregado de la descripción formal de la estancia.
                $emailVars['estancia']       = $contratoData->estancia->descripcion_formal;
                $emailVars['estancia_title'] = $contratoData->estancia->title;
                $emailVars['ESTANCIA_TITLE'] = $contratoData->estancia->title;
                $emailVars['noches']         = $contratoData->noches;
                $emailVars['hotel_name']     = $contratoData->estancia->hotel_name;

                switch ($emailVars['cuotas']) {
                    case 48:
                    case 72:
                        $emailVars['cuotas_title'] = 'SEMANALES';
                        break;
                    case 24:
                    case 36:
                        $emailVars['cuotas_title'] = 'QUINCENALES';
                        break;
                    case 12:
                    case 18:
                        $emailVars['cuotas_title'] = 'MENSUALES';
                        break;
                    default:
                        $emailVars['cuotas_title'] = 'QUINCENALES';
                        break;
                }
        }

        $emailVars['noches']       = $contratoData->noches;
        $emailVars['hotel_name']   = $contratoData->hotel_name;
        $emailVars['edadmaxninos'] = $emailVars['edad_max_ninos'];

        $emailVars['empresa_nombre'] = $contratoData->convenio->empresa_nombre;
        $emailVars['cliente']        = $contratoData->cliente->nombre . ' ' . $contratoData->cliente->apellidos;

        $emailVars['telefono']         = $contratoData->cliente->telefono;
        $emailVars['telefono_casa']    = $contratoData->cliente->telefono_casa;
        $emailVars['telefono_oficina'] = $contratoData->cliente->telefono_oficina;

        $emailVars['ciudad']            = $contratoData->cliente->ciudad . ", " . $contratoData->cliente->provincia;
        $emailVars['city']              = $contratoData->cliente->ciudad;
        $emailVars['estate']            = $contratoData->cliente->provincia;
        $emailVars['e-mail']            = $contratoData->cliente->username;
        $emailVars['codigo_postal']     = $contratoData->cliente->codigo_postal;
        $emailVars['cumpleanos']        = $contratoData->cliente->cumpleanos;
        $emailVars['rfc']               = $contratoData->cliente->RFC;
        $emailVars['direccion_cliente'] = $contratoData->cliente->direccion . " " . $contratoData->cliente->direccion2;

        if ($contratoData->estancia->est_especial == 1) {
            $emailVars['monto_cuotas_num']  = $contratoData->estancia->precio / $contratoData->estancia->cuotas;
            $emailVars['monto_cuotas_str']  = $emailVars['monto_cuotas_num'] . ' ' . $contratoData->divisa;
            $emailVars['enganche_especial'] = "A one time only deposit fee for the amount of <strong>" . $contratoData->estancia->enganche_especial . ' ' . $contratoData->divisa . "</strong>, non refundable.";
        } else {
            $emailVars['monto_cuotas_num']  = $contratoData->precio_de_compra / $contratoData->estancia->cuotas;
            $emailVars['monto_cuotas_str']  = $emailVars['monto_cuotas_num'] . ' ' . $contratoData->divisa;
            $emailVars['enganche_especial'] = '';
        }

        /*$emailVars['monto_cuotas_num'] = $contratoData['Contrato']['precio_de_compra'] / $contratoData['Estancia']['cuotas'];
        $emailVars['monto_cuotas_str'] = $text->currency($emailVars['monto_cuotas_num'], $contratoData['Contrato']['divisa']);*/

        // Fin Diego Enrique Sanchez
        switch ($contratoData->noches) {
            case 4:
                $emailVars['dias_noches_usa_str'] = '4 (four) nights and 5 (five) days';
                break;
            default:
                $emailVars['dias_noches_usa_str'] = '2 (two) nights and 3 (three) days';
                break;
        }
        switch ($contratoData->noches) {
            case 4:
                $emailVars['dias_noches_usa_str_v2'] = 'Four (4) Nights';
                break;
            default:
                $emailVars['dias_noches_usa_str_v2'] = 'Two (2) Nights';
                break;
        }
        $segmentos      = $contratoData->num_segmentos();
        $estancias_2023 = Estancia::where('caducidad', env('EST_VIGENCIA'))->get();
        
        switch ($segmentos) {
            case $segmentos >= 35 && $segmentos <= 38:
            case 72:
            case 18:
                $emailVars['vigencia']       = 'año y medio';
                $emailVars['vigencia_meses'] = '18 meses';
                break;
            
            case 24:
            case 48:
                $emailVars['vigencia']       = 'año';
                $emailVars['vigencia_meses'] = '12 meses';
                break;

            case 12:
                $emailVars['vigencia']       = 'año';
                $emailVars['vigencia_meses'] = '12 meses';
                break;
                
            default:
                $emailVars['vigencia']       = 'año y medio';
                $emailVars['vigencia_meses'] = '18 meses';
                break;
        }

        $emailVars['rym_noches'] = $contratoData->noches;

        // dd($emailVars);
        return $emailVars;
    }

    /**
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-10-03
     * Sustitucion de las llaves definidas en el contrato con los datos del contrato para construir el contrato en texto plano
     * @param  [array] $emailVars ]
     * @param  [array] $contrato
     * @return [string] contrato texto plano
     */
    public function construir_contrato_mx($emailVars, $contrato)
    {

        if ($contrato['Estancia']['descripcion_formal_es_contrato_completo'] == false) {
            if ($contrato['pago_con_nomina']) {
                $contrato_cuerpo = $contrato['Convenio']['contrato_nomina'];
            } else {
                $contrato_cuerpo = $contrato['Convenio']['contrato'];
            }
        } else {
            $contrato_cuerpo = $contrato['Estancia']['descripcion_formal'];
            $contrato_cuerpo = str_replace('[estancia]', '', $contrato_cuerpo);
            $contrato_cuerpo = str_replace(' noches Temporada: ______________________<br>', '<br>', $contrato_cuerpo);
        }

        for ($i = 2; $i >= 1; $i--) {
            foreach ($emailVars as $var => $data) {
                $contrato_cuerpo = str_replace('[' . $var . ']', $data, $contrato_cuerpo);
            }
        }
        return $contrato_cuerpo;
    }
}
