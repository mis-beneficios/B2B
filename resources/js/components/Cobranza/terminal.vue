<template>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-actions">
                    <button class="btn btn-info btn-xs" data-target="#modalUnlock" data-toggle="modal" style="color: white;">
                        <i class="fas fa-unlock-alt">
                        </i>
                        Desbloquear
                    </button>
                </div>
                <h4 class="card-title m-b-0">
                    Filtrado Terminal VUE
                </h4>
            </div>
            <div class="card-body">
                <form action="" @submit.prevent="getInfo" id="formTerminal" method="post">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">
                                        Inicio del rango
                                    </label>
                                    <input v-model="filtrado.fecha_inicio" autocomplete="off" class="form-control" id="fecha_inicio" name="fecha_inicio" type="text" value="">
                                        <span class="text-danger error-titular errors">
                                        </span>
                                    </input>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">
                                        Fin del rango
                                    </label>
                                    <input v-model="filtrado.fecha_fin" autocomplete="off" class="form-control" id="fecha_fin" name="fecha_fin" type="text" value="">
                                        <span class="text-danger error-numero_tarjeta errors">
                                        </span>
                                    </input>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h5 class="card-title mb-2 mt-2">
                                Método de compra:
                            </h5>
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-info btn-sm ">
                                    <input name="nomina" v-model="filtrado.nomina" type="checkbox">
                                        Nomina
                                    </input>
                                </label>
                                <label class="btn btn-info btn-sm">
                                    <input name="terminal" v-model="filtrado.terminal" type="checkbox">
                                        Terminal
                                    </input>
                                </label>
                                <label class="btn btn-info btn-sm ">
                                    <input name="viaserfin" v-model="filtrado.viaserfin" type="checkbox">
                                        Via Serfin
                                    </input>
                                </label>
                            </div>
                            <h5 class="card-title mb-2 mt-2">
                                Estatus de pago:
                            </h5>
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-info btn-sm active ">
                                    <input checked="" name="pagosRechazados"  v-model="filtrado.pagosRechazados"  type="checkbox">
                                        Rechazados
                                    </input>
                                </label>
                                <label class="btn btn-info btn-sm active">
                                    <input checked="" name="pagosPagados"  v-model="filtrado.pagosPagados"  type="checkbox">
                                        Pagados 
                                    </input>
                                </label>
                                <label class="btn btn-info btn-sm active ">
                                    <input checked="" name="pagosPendientes"  v-model="filtrado.pagosPendientes"  type="checkbox">
                                        Pendientes
                                    </input>
                                </label>
                                <label class="btn btn-info btn-sm active ">
                                    <input checked="" name="pagosAnomalías"  v-model="filtrado.pagosAnomalias"  type="checkbox">
                                        Anomalías
                                    </input>
                                </label>
                            </div>
                            <h5 class="card-title mb-2 mt-2">
                                Tipo de tarjeta:
                            </h5>
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-info btn-sm ">
                                    <input name="tipoTarjeta"  v-model="filtrado.credito"  type="radio" value="Credito">
                                        Crédito
                                    </input>
                                </label>
                                <label class="btn btn-info btn-sm">
                                    <input name="tipoTarjeta"  v-model="filtrado.debito"  type="radio" value="Debito">
                                        Débito
                                    </input>
                                </label>
                                <label class="btn btn-info btn-sm active">
                                    <input checked=""   name="tipoTarjeta" type="radio" value="0">
                                        Sin segmentar
                                    </input>
                                </label>
                            </div>
                            <h5 class="card-title mb-2 mt-2">
                                Red bancaria:
                            </h5>
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-info btn-sm ">
                                    <input name="red_bancaria" type="radio" value="MasterCard">
                                        Crédito
                                    </input>
                                </label>
                                <label class="btn btn-info btn-sm">
                                    <input name="red_bancaria" type="radio" value="VISA">
                                        Débito
                                    </input>
                                </label>
                                <label class="btn btn-info btn-sm active">
                                    <input checked="" name="red_bancaria" type="radio" value="0">
                                        Sin segmentar
                                    </input>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h5 class="card-title mb-2 mt-2">
                                Filtrado extra:
                            </h5>
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-info btn-sm active">
                                    <input checked="" id="btnNinguno" type="radio" value="ninguno">
                                        Ninguno
                                    </input>
                                </label>
                                <label class="btn btn-info btn-sm">
                                    <input id="btnPais" type="radio" value="pais">
                                        País
                                    </input>
                                </label>
                                <label class="btn btn-info btn-sm ">
                                    <input id="btnConvenio" type="radio" value="convenio">
                                        Convenio
                                    </input>
                                </label>
                            </div>
                            <div id="contenedor_filtro" style="display:none">
                                <h5 class="card-title mb-2 mt-2">
                                    Filtrado extra:
                                </h5>
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-info btn-sm active">
                                        <input checked="" id="btnNinguno" type="radio" value="ninguno">
                                            Ninguno
                                        </input>
                                    </label>
                                    <label class="btn btn-info btn-sm">
                                        <input id="btnPais" type="radio" value="pais">
                                            País
                                        </input>
                                    </label>
                                    <label class="btn btn-info btn-sm ">
                                        <input id="btnConvenio" type="radio" value="convenio">
                                            Convenio
                                        </input>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row ml-auto">
                        <div class="float-right">
                            <button class="btn btn-dark btn-sm" type="submit">
                                Filtrar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Resultados
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover" id="tableTerminal">
                    <thead>
                        <tr>
                            <th scope="col">
                                Segmento
                                <br/>
                                <small>
                                    # Pago
                                </small>
                            </th>
                            <th scope="col">
                                # Contrato
                                <br/>
                                <small>
                                    Clave Serfin
                                </small>
                            </th>
                            <th scope="col">
                                Cliente
                                <br/>
                                <small>
                                    Convenio
                                </small>
                            </th>
                            <th scope="col">
                                Cantidad
                                <br/>
                                <small>
                                    Cantidad total
                                </small>
                            </th>
                            <th scope="col">
                                Tarjeta asignada
                                <br/>
                                <small>
                                    Entidad bancaria
                                </small>
                            </th>
                            <th scope="col">
                                Estatus
                                <br/>
                                <small>
                                    Motivo del rechazo
                                </small>
                            </th>
                            <th scope="col">
                                F. programada
                                <br/>
                                <small>
                                    Fecha cobro exitoso
                                </small>
                            </th>
                            <th scope="col" width="140px">
                                Acciones
                                <br/>
                                <small>
                                    Avance de pagos
                                </small>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
</template>
<script src="{{asset('js/app.js')}}"></script>
<script>
export default {
  data () {
    return {
        filtrado:{},
    }
  },
  methods: {
    getInfo() {
        this.filtrado.fecha_inicio = '2023-02-20';
        this.filtrado.fecha_fin = '2023-02-20';
        console.log(this.filtrado);
        this.axios
        .get('cobranza-get-data', this.filtrado)
        .then(function(response){
            console.log(response.data);
        })
        .catch(function(error){
            console.log(error);
        })
    },
  },
  mounted(){
    this.filtrado.fecha_inicio = '2023-02-20';
    this.filtrado.fecha_fin = '2023-02-20';
    // this.getInfo();
    console.log(this.filtrado);
  }
}
</script>

<style lang="css" scoped>
</style>