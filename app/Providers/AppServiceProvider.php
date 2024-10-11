<?php

namespace App\Providers;

// use App\Contrato;
// use App\Observers\ContratosObserver;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Convenio;
use Cache;
class AppServiceProvider extends ServiceProvider
{

    private $expiracion = 3600;
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // setcookie('cookie_', false, $this->expiracion, '/');
        // setcookie('cookie_', 'generar_respaldo', time() + $this->expiracion, '/');

        // dd($_COOKIE['cookie_']);
        Paginator::useBootstrap();
        /**
         * Observadores
         */
        // Contrato::observe(ContratosObserver::class);

        Carbon::setUTF8(true);
        // Carbon::setLocale(config('app.locale'));
        setlocale(LC_ALL, 'es_MX', 'es', 'ES', 'es_MX.utf8');
        Carbon::setLocale('es');
        ini_set('max_execution_time', 360000);
        session(['unlock_cards' => false]);

        view()->composer('*', function ($view) {
            $color_system = (isset($_COOKIE['color_system'])) ? $_COOKIE['color_system'] : 'white';
            $view->with('color_system', $color_system);
        });

        // view()->composer('*', function ($view) {
        //     $bienvenidas =  Cache::remember('bienvenidas', 3600, function() {
        //          return Convenio::whereNotNull('img_bienvenida')->get(['img_bienvenida','llave','empresa_nombre','logo']);
        //     });
        //     $view->with('bienvenidas', $bienvenidas);
        // });
    }
}
