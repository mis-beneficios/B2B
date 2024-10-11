@extends('layouts.admin.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            Equipos
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Ejecutivos
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover dataTable" id="table_usuarios" role="grid" style="width:100%">
                        <thead>
                            <tr role="row">
                                <th>
                                    Ejecutivo
                                </th>
                                <th >
                                    Usuario
                                </th>
                                <th>
                                    Equipo
                                </th>
                                <th>
                                    Comisiones generadas
                                </th>
                                <th>
                                    Comisiones pagables
                                </th>
                                <th >
                                    Opciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ejecutivos as $ejecutivo)
                                <tr>
                                    <td>
                                        {{ $ejecutivo->fullName }}
                                    </td>
                                    <td>
                                        {{ $ejecutivo->username }}
                                    </td>
                                    <td>
                                       <b>
                                            {{ $ejecutivo->equipo->title }}
                                       </b>
                                    </td>
                                    <td>
                                        ${{ number_format($ejecutivo->comisiones_generadas($ejecutivo->admin_padre->id),2) }}
                                    </td>
                                    <td>
                                        ${{ number_format($ejecutivo->comisiones_pagables($ejecutivo->admin_padre->id),2) }}
                                    </td>
                                    <td>
                                        <a href="{{ route('users.clientes_ejecutivo', $ejecutivo->id) }}" class="btn btn-primary btn-xs mr-1">
                                            <i class="fas fa-users"></i>
                                            {{ $ejecutivo->mis_clientes($ejecutivo->admin_padre->id) }}
                                        </a>
                                        <a href="{{ route('contratos.listar_contratos_ejecutivo', $ejecutivo->id) }}" class="btn btn-info btn-xs">
                                            <i class="fas fa-file-pdf"></i>
                                            {{-- {{ $ejecutivo->mis_contratos($ejecutivo->id) }} --}}
                                            {{ $ejecutivo->mis_contratos($ejecutivo->admin_padre->id) }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
<script>
    $('#table_usuarios').dataTable();
</script>
@endsection
