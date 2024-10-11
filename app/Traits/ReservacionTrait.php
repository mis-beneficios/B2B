<?php
namespace App\Traits;

use App\Habitacion;
use Auth;
use Carbon\Carbon;
trait ReservacionTrait
{

    /**
     * Autor: Isw Diego Enrique Sanchez
     * Creado: 2022-12-21
     * Agrega o modifica las habitaciones asociadas a la reservacion
     * Registro por habitacion asociada
     * Se utiliza tanto para la creacion como edicion de los ajustes de la reservacion
     * @param  [type] $request
     * @param  [type] $reservacion
     * @return [boolean] $numero_habitaciones
     */
    public function editarHabitaciones($request, $reservacion)
    {
        try {
            $numero_habitaciones = 1;

            foreach ($request->num_habitacion as $key => $v) {
                if (isset($request->habitacion_id[$key])) {
                    $habitacion = Habitacion::where('id', $request->habitacion_id[$key])->first();
                } else {
                    $habitacion = new Habitacion;
                }
                $habitacion->user_id         = $reservacion->user_id;
                $habitacion->padre_id        = Auth::user()->admin_padre->id;
                $habitacion->estancia        = $reservacion->title;
                $habitacion->reservacione_id = $request->reservacion_id;
                $habitacion->noches          = $request->noches[$key];
                $habitacion->adultos         = $request->adultos[$key];

                $habitacion->adultos_extra    = 0;
                $habitacion->menores_extra    = 0;
                $habitacion->fecha_de_ingreso = $reservacion->fecha_de_ingreso;
                $habitacion->fecha_de_salida  = $reservacion->fecha_de_salida;

                $nom = "edad_nino" . $v;

                if (!is_null($request->input($nom))) {
                    $habitacion->menores = count($request->input($nom));
                    switch (count($request->input($nom))) {
                        case 1:
                            $habitacion->edad_menor_1 = $request->input($nom)[0];
                            $habitacion->edad_menor_2 = 0;
                            $habitacion->edad_menor_3 = 0;
                            $habitacion->edad_menor_4 = 0;
                            $habitacion->edad_menor_5 = 0;
                            break;
                        case 2:
                            $habitacion->edad_menor_1 = $request->input($nom)[0];
                            $habitacion->edad_menor_2 = $request->input($nom)[1];
                            $habitacion->edad_menor_3 = 0;
                            $habitacion->edad_menor_4 = 0;
                            $habitacion->edad_menor_5 = 0;
                            break;
                        case 3:
                            $habitacion->edad_menor_1 = $request->input($nom)[0];
                            $habitacion->edad_menor_2 = $request->input($nom)[1];
                            $habitacion->edad_menor_3 = $request->input($nom)[2];
                            $habitacion->edad_menor_4 = 0;
                            $habitacion->edad_menor_5 = 0;
                            break;
                        case 4:
                            $habitacion->edad_menor_1 = $request->input($nom)[0];
                            $habitacion->edad_menor_2 = $request->input($nom)[1];
                            $habitacion->edad_menor_3 = $request->input($nom)[2];
                            $habitacion->edad_menor_4 = $request->input($nom)[3];
                            $habitacion->edad_menor_5 = 0;
                            break;
                        case 5:
                            $habitacion->edad_menor_1 = $request->input($nom)[0];
                            $habitacion->edad_menor_2 = $request->input($nom)[1];
                            $habitacion->edad_menor_3 = $request->input($nom)[2];
                            $habitacion->edad_menor_4 = $request->input($nom)[3];
                            $habitacion->edad_menor_5 = $request->input($nom)[4];
                            break;
                    }
                }
                $nom_j = "edad_junior" . $v;

                if (!is_null($request->input($nom_j))) {
                    $habitacion->juniors = count($request->input($nom_j));
                    switch (count($request->input($nom_j))) {
                        case 1:
                            $habitacion->edad_junior_1 = $request->input($nom_j)[0];
                            $habitacion->edad_junior_2 = 0;
                            $habitacion->edad_junior_3 = 0;
                            $habitacion->edad_junior_4 = 0;
                            $habitacion->edad_junior_5 = 0;
                            break;
                        case 2:
                            $habitacion->edad_junior_1 = $request->input($nom_j)[0];
                            $habitacion->edad_junior_2 = $request->input($nom_j)[1];
                            $habitacion->edad_junior_3 = 0;
                            $habitacion->edad_junior_4 = 0;
                            $habitacion->edad_junior_5 = 0;
                            break;
                        case 3:
                            $habitacion->edad_junior_1 = $request->input($nom_j)[0];
                            $habitacion->edad_junior_2 = $request->input($nom_j)[1];
                            $habitacion->edad_junior_3 = $request->input($nom_j)[2];
                            $habitacion->edad_junior_4 = 0;
                            $habitacion->edad_junior_5 = 0;
                            break;
                        case 4:
                            $habitacion->edad_junior_1 = $request->input($nom_j)[0];
                            $habitacion->edad_junior_2 = $request->input($nom_j)[1];
                            $habitacion->edad_junior_3 = $request->input($nom_j)[2];
                            $habitacion->edad_junior_4 = $request->input($nom_j)[3];
                            $habitacion->edad_junior_5 = 0;
                            break;
                        case 5:
                            $habitacion->edad_junior_1 = $request->input($nom_j)[0];
                            $habitacion->edad_junior_2 = $request->input($nom_j)[1];
                            $habitacion->edad_junior_3 = $request->input($nom_j)[2];
                            $habitacion->edad_junior_4 = $request->input($nom_j)[3];
                            $habitacion->edad_junior_5 = $request->input($nom_j)[4];
                            break;
                    }
                }
                $habitacion->created = Carbon::now()->format('Y-m-d h:i:s');
                $habitacion->save();
                // dd($habitacion);
                // if (isset($request->habitacion_id[$key])) {
                //     $hab_id = $request->habitacion_id[$key];
                // } else {
                //     $hab_id = null;
                // }
                // $res = Habitacion::updateOrCreate(['id' => $hab_id], $habitacion);

                $numero_habitaciones++;
            }

            return $numero_habitaciones;
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

}
