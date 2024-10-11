@extends('layouts.pagina.app')
@section('content')
<div class="container">
    <div class="section_tittle">
        <div class="ym-cbox">
            <h2>
                <strong>
                    Recently affiliated companies:
                </strong>
            </h2>
            <div>
                <p class="mb-3">
                    If your company is already a member of the Optucorp family, register for your much deserved vacation online and travel at your convenience. (Packages are limited, so sign up quickly to secure your vacation).
                </p>
                <div class="row text-center">
                    <div class="col-md-4">
                        <a href="http://build.optumed.es/world/Es_mx/Empresas_Afiliadas/Listado">
                            <img alt="" src="{{ env('STORAGE_EU') }}/img/elements/companies/Miami-Dade-County.png" style="border-width: 0px; border-style: solid; width: 150px; height: 80px;"/>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="http://build.optumed.es/world/Es_mx/Empresas_Afiliadas/Listado">
                            <img alt="" src="{{ env('STORAGE_EU') }}/img/elements/companies/NYC_DOE_Logo_.png" style="border-width: 0px; border-style: solid; width: 150px; height: 80px;"/>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="http://build.optumed.es/world/Es_mx/Empresas_Afiliadas/Listado">
                            <img alt="" src="{{ env('STORAGE_EU') }}/img/elements/companies/Broward.jpg" style="border-width: 0px; border-style: solid; width: 200px; height: 80px;"/>
                        </a>
                    </div>
                </div>
            </div>
            <p class="mt-4">
                If your company does not have yet our benefit program, please e-mail us at
                <br/>
                <a href="mailto:agreement@optucorp.com?&subject=My%20Agreement">
                    <strong>
                        agreement@optucorp.com
                    </strong>
                </a>
            </p>
            <p>
                The
                <b>
                    {{ env('APP_NAME_EU') }}
                </b>
                family is proud to include over 1,000 great companies, local, regional, national, and international.   We are proud to have government, universities corporations, and unions that endorse our unique, extraordinary program.  The Optucorp family stands behind our sincere commitment to excellence and to present this new concept travel benefit to employees and their loved ones.
            </p>
            <p>
                We maintain excellent communication with our clients and we are committed to provide the best benefits and service to their workforce.
            </p>
            <br/>
            <p>
                <img alt="" class="bordered flexible" src="{{ env('STORAGE_EU') }}/img/elements/world/empr_mx.jpg" style="width: 100%;"/>
            </p>
        </div>
    </div>
</div>
@endsection
