const mix = require('laravel-mix');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
// mix.js('resources/js/app.js', 'public/js').vue({
//     version: 2,
//     extractVueStyles: true
// }).sass('resources/sass/app.scss', 'public/css').sourceMaps();
// 
// 
/**
 * Creado: 2023-03-123 
 * Autor: ISW Diego Enrique Sanchez 
 */
// mix.js(['public/back/assets/plugins/jquery/jquery.min.js', 'public/back/assets/plugins/bootstrap/js/popper.min.js', 'public/back/assets/plugins/bootstrap/js/bootstrap.min.js', 'public/back/js/jquery.slimscroll.js', 'public/back/js/waves.js', 'public/back/js/sidebarmenu.js', 'public/back/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js', 'public/back/assets/plugins/sparkline/jquery.sparkline.min.js', 'public/back/assets/plugins/sparkline/jquery.sparkline.min.js', 'public/back/js/custom.min.js', 'public/back/assets/plugins/d3/d3.min.js', 'public/back/assets/plugins/c3-master/c3.min.js', 'public/back/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.m', 'public/back/assets/plugins/sweetalert/sweetalert.min.js', 'public/back/assets/plugins/Chart.js/chartjs.init.js', 'public/back/assets/plugins/Chart.js/Chart.min.js', 'public/assets/plugins/imask/imask.js', 'public/back/assets/plugins/styleswitcher/jQuery.style.switcher.js', 'public/back/assets/plugins/datatables/jquery.dataTables.min.js', 'public/plugins/toastr/build/toastr.min.js', 'public/plugins/alertifyjs/build/alertify.min.js', 'public/plugins/moment/min/moment.min.js', 'public/plugins/moment/min/locales.min.js', 'public/js/express-useragent.min.js',
//     // 'resources/js/app.js'
// ], 'public/js').vue({
//     version: 2,
//     extractVueStyles: true
// }).sass(['public/back/assets/plugins/bootstrap/css/bootstrap.min.css', 'public/back/assets/plugins/select2/dist/css/select2.min.css', 'public/back/assets/plugins/bootstrap-select/bootstrap-select.min.css', 'public/back/assets/plugins/multiselect/css/multi-select.css', 'public/back/assets/plugins/c3-master/c3.min.css', 'public/back/css/style.css', 'public/plugins/toastr/build/toastr.css'
//     'public/back/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css', 'public/plugins/alertifyjs/build/css/alertify.min.css', 'public/assets/fontawesome/css/all.min.css', 'public/css/custom.css',
// ], 'public/css').sourceMaps();