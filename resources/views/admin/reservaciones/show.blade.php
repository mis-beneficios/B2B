<style>
/*    .row{
        color:grey;
    }*/
</style>
<div class="card-body form">
    <h4 class="card-title">Datos del cliente</h4>
    <div class="row">
        <div class="col-lg-4">
            <address>
                <strong>Cliente</strong>
                <br/>
                {{ $reservacion->cliente->fullName }}
            </address>
        </div>
        <div class="col-lg-4">
            <address>
                <strong>Correo electrónico</strong>
                <br/>
                {{  $reservacion->cliente->username  }}
            </address>
        </div>
        <div class="col-lg-4">
            <address>
                <strong>Teléfono</strong>
                <br/>
                {{  $reservacion->cliente->telefono  }}
            </address>
        </div>
        <hr/>
        <div class="col-md-12 m-t-30">
        <h4 class="card-title">Datos de la reservación</h4>
        </div>
        <div class="col-md-2">
            <address>    
                <strong class="text-info">
                    Folio
                </strong>
                <br>
                {{ $reservacion->id }}
            </address>
            
        </div>
        <div class="col-md-6">
            <address>
                <strong class="text-info">
                    Titulo
                </strong>
                <br>
                {{ $reservacion->title }}
            </address>
        </div>
        <div class="col-md-4">
            <address>
            <strong class="text-info">
                Reservado a nombre de:
            </strong>
            <br>
                {{ $reservacion->nombre_de_quien_sera_la_reservacion }}
            </address>
        </div>
        <div class="col-md-6">
            <address>
                <strong class="text-info">
                    Correo electrónico de reservación
                </strong>
                <br>
                    {{ $reservacion->email }}
            </address>
        </div>
        <div class="col-md-4">
            <address>
                <strong class="text-info">
                    Teléfono
                </strong>
                <br>
                {{ $reservacion->telefono }}
            </address>
        </div>
        <div class="col-md-6">
            <address>
            <strong class="text-info">
                Fecha de check-in y check-out
            </strong>
            <br>
                {{ $reservacion->fecha_de_ingreso . " " . $reservacion->entrada . " - " . $reservacion->fecha_de_salida  . " " . $reservacion->salida }}
            </address>
        </div>
        <div class="col-md-4">
            <address>
            <strong class="text-info">
                Destino
            </strong>
            <br>
                {{ $reservacion->destino }}
            </address>
        </div>
        <div class="col-md-4">
            <address>
                
            <strong class="text-info">
                Estatus
            </strong>
            <br>
                {{ $reservacion->estatus }}
            </address>
        </div>
        <div class="col-md-4">
            <address>
            <strong class="text-info">
                Creado
            </strong>
            <br>
                {{ $reservacion->created }}
            </address>
        </div>
        <div class="col-md-4">
            <address>
            <strong class="text-info">
                Hotel
            </strong>
            <br>
                {{ $reservacion->hotel }}
            </address>
        </div>
        <div class="col-md-4">
            <address>
            <strong class="text-info">
                Habitaciones
            </strong>
            <br>
                {{ $reservacion->habitaciones }}
            </address>
        </div>
        <div class="col-md-4">
            <address>
                
            <strong class="text-info">
                Clave
            </strong>
            <br>
                {{ $reservacion->clave }}
            </address>
        </div>
        <div class="col-md-4">
            <address>
                
            <strong class="text-danger">
                Contratos asociados
            </strong>
            <br>
                <ul>
                    @foreach ($reservacion->contratos as $con)
                    <li>
                        {{ $con->id }}
                    </li>
                    @endforeach
                </ul>

            </address>
        </div>
        <div class="col-md-12">
            <address>
            <strong class="text-info">
                Detalles
            </strong>
            <br>
                {!! $reservacion->detalle !!}
            </address>
        </div>
    </div>
    @if ($reservacion->fecha_de_pago != null)
    <div class="row">
        <div class="col-md-4">
            <address>
                
            <strong class="text-info">
                Fecha de pago
            </strong>
            <br>
                {{ $reservacion->fecha_de_pago }}
            </address>
        </div>
        <div class="col-md-4">
            <address>
                
            <strong class="text-info">
                Cantidad $
            </strong>
            <br>
                {{ number_format($reservacion->cantidad_pago,2) }}MXN
            </address>
        </div>
    </div>
    @endif
     @if ($reservacion->fecha_de_pago_1 != null)
    <div class="row">
        <div class="col-md-4">
            <address>
                
            <strong class="text-info">
                Fecha de pago 1
            </strong>
            <br>
                {{ $reservacion->fecha_de_pago_1 }}
            </address>
        </div>
        <div class="col-md-4">
            <address>
                
            <strong class="text-info">
                Cantidad $
            </strong>
            <br>
                {{ number_format($reservacion->cantidad_pago_1, 2) }}MXN
            </address>
        </div>
    </div>
    @endif
     @if ($reservacion->fecha_de_pago_2 != null)
    <div class="row">
        <div class="col-md-4">
            <address>
                
            <strong class="text-info">
                Fecha de pago 2
            </strong>
            <br>
                {{ $reservacion->fecha_de_pago_2 }}
            </address>
        </div>
        <div class="col-md-4">
            <address>
                
            <strong class="text-info">
                Cantidad $
            </strong>
            <br>
                {{ number_format($reservacion->cantidad_pago_2, 2) }}MXN
            </address>
        </div>
    </div>
    @endif
     @if ($reservacion->fecha_de_pago != null)
    <div class="row">
        <div class="col-md-4">
            <address>
                
            <strong class="text-info">
                Fecha de pago 3
            </strong>
            <br>
                {{ $reservacion->fecha_de_pago_3 }}
            </address>
        </div>
        <div class="col-md-4">
            <address>
                
            <strong class="text-info">
                Cantidad $
            </strong>

                {{ number_format($reservacion->cantidad_pago_3,2) }} MXN
            </address>
        </div>
    </div>
    @endif
    <hr>

    <div class="row">
        <div class="col-md-3">
            <a class="btn btn-dark btn-sm" href="{{ route('pdf_reserver', $reservacion->id) }}" target="_blank">
                Descargar
            </a>
        </div>
    </div>
</div>