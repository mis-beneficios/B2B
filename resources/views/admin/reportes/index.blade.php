@extends('layouts.admin.app')
@livewireStyles
@livewireScripts
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">
            <a href="{{ route('dashboard') }}">
                Reportes
            </a>
        </h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item active">
                Reportes
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-xlg-12">
        <div class="card">
            <ul class="nav nav-tabs customtab" role="tablist">
                <li class="nav-item"> 
                    <a class="nav-link active" data-toggle="tab" href="#home2" role="tab" aria-expanded="true">
                        <span class="hidden-sm-up">
                            <i class="ti-home"></i>
                        </span> 
                        <span class="hidden-xs-down">
                            Total de registros
                        </span>
                    </a> 
                </li>
                <li class="nav-item"> 
                    <a class="nav-link" data-toggle="tab" href="#profile2" role="tab" aria-expanded="false">
                        <span class="hidden-sm-up">
                            <i class="ti-user"></i>
                        </span> 
                        <span class="hidden-xs-down">
                            Reporte general
                        </span>
                    </a> 
                </li>
        {{--         <li class="nav-item"> 
                    <a class="nav-link" data-toggle="tab" href="#messages2" role="tab" aria-expanded="false">
                        <span class="hidden-sm-up">
                            <i class="ti-email"></i>
                        </span> 
                        <span class="hidden-xs-down">
                            Messages
                        </span>
                    </a> 
                </li> --}}
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="home2" role="tabpanel" aria-expanded="true">
                     @livewire('reportes.clientes')
                </div>
                <div class="tab-pane p-20" id="profile2" role="tabpanel" aria-expanded="false">
                     @livewire('reportes.cobranza')
                </div>
                <div class="tab-pane p-20" id="messages2" role="tabpanel" aria-expanded="false">3</div>
            </div>
        </div>
       
    </div>
</div>
@endsection


@section('script')
<script>

</script>
@endsection
