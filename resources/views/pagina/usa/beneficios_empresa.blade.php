@extends('layouts.pagina.app')
@section('content')
<div class="container">
    <section class="top_place mb-5">
        <div class="ym-cbox mt-3">
            <p>
                We provide a unique and convenient employee benefit that gives staff members and their loved ones the opportunity to save for a vacation and travel when their schedule allows.  After an Optucorp vacation, employees come back to work refreshed, productivity and performance will increase.
            </p>
            <div>
                <divclass="mt-3">
                    <p>
                        Optucorp is dedicated to offering great travel benefits to employees and their loved ones, promote tourism, and contribute to economic growth for hard-working people all over the world.   For over a decade, Optucorp has provided vacations to employees and their loved ones.
                    </p>
                </divclass="mt-3">
            </div>
            <div class="mt-3">
                <img alt="" class="bordered flexible" src="{{ env('STORAGE_EU') }}/img/elements/world/us/nemp_us.jpg " style="width: 100%;"/>
            </div>
            <div class="mt-3">
                <p>
                    Optucorp has created a new and unique concept that makes travel convenient for your staff and their loved ones.  We pride ourselves on world class customer service.
                </p>
            </div>
        </div>
        <p class="mt-5">
            If your company does not have yet our benefit program, please e-mail us at
            <a href="mailto:agreement@optucorp.com?&subject=My%20Agreement">
                <br>
                    <strong>
                        agreement@optucorp.com
                    </strong>
                </br>
            </a>
        </p>
    </section>
</div>
@endsection
@section('script')
@endsection
