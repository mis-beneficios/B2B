<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>
            Reservacion {{ $reservacion->id }}
        </title>
        <style>
            .clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #5D6975;
  text-decoration: underline;
}

body {
  position: relative;
  width: 100%;  
  /*height: 29.7cm; */
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 12px; 
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 10px;
}

#logo {
  text-align: center;
  margin-bottom: 10px;
}

#logo img {
  width: 30%;
}

h1 {
  border-top: 1px solid  #5D6975;
  border-bottom: 1px solid  #5D6975;
  color: #5D6975;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 0 0 20px 0;
  background: url(dimension.png);
}

#project {
  float: left;
}

#project span {
  color: #5D6975;
  text-align: right;
  width: 30%;
  margin-right: 10px;
  display: inline-block;
  font-size: 14px;
}

#company {
  float: right;
  text-align: right;
}

#project div,
#company div {
  white-space: nowrap;    
  font-size: 16px;    
  margin-bottom: 5px;
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table tr:nth-child(2n-1) td {
  background: #F5F5F5;
}

table th,
table td {
  text-align: center;
}

table th {
  padding: 5px 20px;
  color: #5D6975;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
}

table .service,
table .desc {
  text-align: left;
}

table td {
  padding: 20px;
  text-align: right;
}

table td.service,
table td.desc {
  vertical-align: top;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.grand {
  border-top: 1px solid #5D6975;;
}

#notices .notice {
  color: #5D6975;
  font-size: 1.2em;
}

footer {
  color: #5D6975;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #C1CED9;
  padding: 8px 0;
  text-align: center;
}
        </style>
    </head>
    <body>
        <header class="clearfix">
            <div id="logo">
                <img src="{{ asset('images/icono01.png') }}">
                </img>
            </div>
            <h1>
                Reservación #{{ $reservacion->id }}
            </h1>
            <div id="project">
                <div>
                    <span>
                        Titulo
                    </span>
                    {{ $reservacion->title }}
                </div>
                <div>
                    <span>
                        Cliente
                    </span>
                    {{ $reservacion->cliente->fullName }}
                </div>
                <div>
                    <span>
                        Reservado a nombre de
                    </span>
                    {{ $reservacion->nombre_de_quien_sera_la_reservacion }}
                </div>
                <div>
                    <span>
                        Email
                    </span>
                    <a href="mailto:{{ $reservacion->email }}">
                        {{ $reservacion->email }}
                    </a>
                </div>
                <div>
                    <span>
                        Telefono
                    </span>
                    {{ $reservacion->telefono }}
                </div>
                <div>
                    <span>
                        Fecha de check-in y check-out
                    </span>
                    {{ $reservacion->fecha_de_ingreso . " " . $reservacion->entrada . " - " . $reservacion->fecha_de_salida  . " " . $reservacion->salida }}
                </div>
                <div>
                    <span>
                        Telefono
                    </span>
                    {{ $reservacion->telefono }}
                </div>
                <div>
                    <span>
                        Destino
                    </span>
                    {{ $reservacion->destino }}
                </div>
                <div>
                    <span>
                        Estatus
                    </span>
                    {{ $reservacion->estatus }}
                </div>
                <div>
                    <span>
                        Registrado el
                    </span>
                    {{ $reservacion->created }}
                </div>
                <div>
                    <span>
                        Hotel
                    </span>
                    {{ $reservacion->hotel }}
                </div>
                <div>
                    <span>
                        Habitaciones
                    </span>
                    {{ $reservacion->habitaciones }}
                </div>
                <div>
                    <span>
                        Clave
                    </span>
                    {{ $reservacion->clave }}
                </div>
                <div>
                    <span>
                        Contratos asociados
                    </span>
                    @foreach ($reservacion->contratos as $con)
                        {{ $con->contrato_id }},
                    @endforeach
                </div>
                <div>
                    <span>
                        Detalles
                    </span>
                    {{ $reservacion->detalle }}
                </div>
                @if ($reservacion->fecha_de_pago != null)
                <div class="col-md-4">
                    <span class="text-muted">
                        Fecha de pago
                    </span>
                    <h6>
                        {{ $reservacion->fecha_de_pago }}
                    </h6>
                </div>
                <div class="col-md-4">
                    <span class="text-muted">
                        Cantidad $
                    </span>
                    <h6>
                        {{ $reservacion->cantidad_pago }}
                    </h6>
                </div>
                @endif
                 @if ($reservacion->fecha_de_pago_1 != null)
                <div class="row">
                    <div class="col-md-4">
                        <span class="text-muted">
                            Fecha de pago 1
                        </span>
                        <h6>
                            {{ $reservacion->fecha_de_pago_1 }}
                        </h6>
                    </div>
                    <div class="col-md-4">
                        <span class="text-muted">
                            Cantidad $
                        </span>
                        <h6>
                            {{ $reservacion->cantidad_pago_1 }}
                        </h6>
                    </div>
                </div>
                @endif
                @if ($reservacion->fecha_de_pago_2 != null)
                <div class="row">
                    <div class="col-md-4">
                        <span class="text-muted">
                            Fecha de pago 2
                        </span>
                        <h6>
                            {{ $reservacion->fecha_de_pago_2 }}
                        </h6>
                    </div>
                    <div class="col-md-4">
                        <span class="text-muted">
                            Cantidad $
                        </span>
                        <h6>
                            {{ $reservacion->cantidad_pago_2 }}
                        </h6>
                    </div>
                </div>
                @endif
     @if ($reservacion->fecha_de_pago != null)
                <div class="row">
                    <div class="col-md-4">
                        <span class="text-muted">
                            Fecha de pago 3
                        </span>
                        <h6>
                            {{ $reservacion->fecha_de_pago_3 }}
                        </h6>
                    </div>
                    <div class="col-md-4">
                        <span class="text-muted">
                            Cantidad $
                        </span>
                        <h6>
                            {{ $reservacion->cantidad_pago_3 }}
                        </h6>
                    </div>
                </div>
                @endif
            </div>
        </header>
        <footer>
            Created By: Isw. Diego Sanchez
        </footer>
    </body>
</html>