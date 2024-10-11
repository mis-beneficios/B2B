<link href="{{ asset('back/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"/>
<link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" rel="stylesheet"/>
<link href="{{ asset('back/assets/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('back/assets/plugins/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('back/assets/plugins/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('back/assets/plugins/c3-master/c3.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('back/css/style.css') }}" rel="stylesheet"/>
{{--
<link href="{{ asset('back/css/colors/mbv-dark.css') }}" id="theme" rel="stylesheet"/>
--}}
<link href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css" rel="stylesheet"/>
<link href="{{ asset('back/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet"/>
<link href="{{ asset('back/assets/plugins/clockpicker/dist/jquery-clockpicker.min.css') }}" rel="stylesheet">
<!-- Popup CSS -->
<link href="{{ asset('back/assets/plugins/Magnific-Popup-master/dist/magnific-popup.css') }}" rel="stylesheet">
<style>
    .btn-xs{
        padding: 0.25rem 0.5rem;
        font-size: 10px;
    }

</style>
@switch($color_system)
    @case('white')
        @php
            $theme =  asset('back/css/colors/blue.css') 
        @endphp
        @break
        @case('black')
        @php
            $theme =  asset('back/css/colors/mbv-dark.css') 
        @endphp
        @break

        @case('green')
        @php
            $theme =  asset('back/css/colors/green.css') 
        @endphp
        @break
        @case('green-dark')
        @php
            $theme =  asset('back/css/colors/green-dark-2.css') 
        @endphp
        @break
        @case('red')
        @php
            $theme =  asset('back/css/colors/red.css') 
        @endphp
        @break
        @case('red-dark')
        @php
            $theme =  asset('back/css/colors/red-black-2.css') 
        @endphp
        @break
        @case('purple')
        @php
            $theme =  asset('back/css/colors/purple.css') 
        @endphp
        @break
        @case('purple-dark')
        @php
            $theme =  asset('back/css/colors/purple-dark-2.css') 
        @endphp
        @break
        @case('mx')
        @php
            $theme =  asset('back/css/colors/mx.css') 
        @endphp
        @break
        @case('navidad')
        @php
            $theme =  asset('back/css/colors/navidad.css') 
        @endphp
        @break
        @case('halloween')
        @php
            $theme =  asset('back/css/colors/halloween.css') 
        @endphp
        @break
    @default
        @php
            $theme =  asset('back/css/colors/blue.css') 
        @endphp
@endswitch
<link href="{{ asset('plugins/toastr/build/toastr.css') }}" rel="stylesheet"/>
{{--
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
--}}
<meta content="{{ csrf_token() }}" name="csrf-token"/>
<link href="{{ asset('back/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('plugins/alertifyjs/build/css/alertify.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/custom.css') }}" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.dataTables.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.3.1/css/rowGroup.dataTables.min.css">
{{-- PikaDay --}}
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">

<link href="{{ asset('back/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
<link href="{{ asset('back/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

@if (env('APP_PAIS_ID') == 7 || Auth::user()->role == 'client')
    {{-- <link href="{{ asset('back/css/colors/halloween.css') }}" id="theme" rel="stylesheet"/> --}}
    <link href="{{ asset('back/css/colors/blue.css') }}" id="theme" rel="stylesheet"/>
@else
<link href="{{ $theme }}" id="theme" rel="stylesheet"/>
@endif
<script>
    var baseuri='{!!asset('');!!}';
    var baseadmin='{!!asset('').'admin/'!!}';
    var auth = '{{ Auth::check() }}';
</script>
<script src="{{ asset('back/assets/plugins/jquery/jquery.min.js') }}">
</script>
<script src="{{ asset('back/assets/plugins/bootstrap/js/popper.min.js') }}">
</script>
<script src="{{ asset('back/assets/plugins/bootstrap/js/bootstrap.min.js') }}">
</script>
<script src="{{ asset('back/js/jquery.slimscroll.js') }}">
</script>
<script src="{{ asset('back/js/waves.js') }}">
</script>
<script src="{{ asset('back/js/sidebarmenu.js') }}">
</script>
<script src="{{ asset('back/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}">
</script>
<script src="{{ asset('back/assets/plugins/sparkline/jquery.sparkline.min.js') }}">
</script>
<script src="{{ asset('back/assets/plugins/sparkline/jquery.sparkline.min.js') }}">
</script>
<script src="{{ asset('back/js/custom.min.js') }}">
</script>
<script src="{{ asset('back/assets/plugins/d3/d3.min.js') }}">
</script>
<script src="{{ asset('back/assets/plugins/c3-master/c3.min.js') }}">
</script>
<script src="{{ asset('back/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}">
</script>
<!-- Magnific popup JavaScript -->
<script src="{{ asset('back/assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('back/assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup-init.js') }}"></script>
{{--
<script src="{{ asset('back/assets/plugins/sweetalert/sweetalert.min.js') }}">
</script>
--}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11">
</script>
{{--
<script src="{{ asset('back/assets/plugins/Chart.js/chartjs.init.js') }}">
</script>
--}}
{{--
<script src="{{ asset('back/assets/plugins/Chart.js/Chart.min.js') }}">
</script>
--}}
<script crossorigin="anonymous" integrity="sha512-kdpGWY5wS6yTcqKxo6c14+4nk99hWFTwQ5XtSyELJxVwpWH23MN80iTVzkMg1jv3FZbdKPbFWLr98AA03/zPuA==" referrerpolicy="no-referrer" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js">
</script>
<script crossorigin="anonymous" integrity="sha512-/0KN09Ho0bS7VTW0fgLRRaHcUH+1h3sdUDlB6c2eEWSffVAAgBMnVqIRV3GR0BwUAcThGIBifHNP1fMU97pA7Q==" referrerpolicy="no-referrer" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.js">
</script>
{{--
<script src="https://unpkg.com/imask">
</script>
--}}
<script src="{{ asset('assets/plugins/imask/imask.js') }}">
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js">
</script>
<script src="{{ asset('back/assets/plugins/styleswitcher/jQuery.style.switcher.js') }}">
</script>
<script src="{{ asset('back/assets/plugins/datatables/jquery.dataTables.min.js') }}">
</script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js">
</script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js">
</script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js">
</script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js">
</script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js">
</script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js">
</script>
<script src="https://cdn.datatables.net/rowgroup/1.3.1/js/dataTables.rowGroup.min.js">
</script>
<script src="https://cdn.datatables.net/fixedheader/3.3.2/js/dataTables.fixedHeader.min.js">
</script>

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js">
</script> --}}
<script src="{{ asset('plugins/toastr/build/toastr.min.js') }}">
</script>
<script src="{{ asset('plugins/alertifyjs/build/alertify.min.js') }}">
</script>
<script src="{{ asset('plugins/moment/min/moment.min.js') }}">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/es.min.js"></script>
{{-- <script src="{{ asset('plugins/moment/min/locales.min.js') }}">
</script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js" type="text/javascript">
</script> --}}
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" type="text/javascript">
</script>
<!-- include summernote css/js -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js">
</script>
<script src="{{ asset('js/express-useragent.min.js') }}">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js">
</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js">
</script>
<script src="{{ asset('back/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}">
</script>
<script src="{{ asset('back/assets/plugins/clockpicker/dist/jquery-clockpicker.min.js') }}"></script>

{{-- PikaDay --}}
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>

<!-- Date Picker Plugin JavaScript -->
<script src="{{ asset('back/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>