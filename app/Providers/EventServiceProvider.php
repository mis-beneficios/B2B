<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class           => [
            SendEmailVerificationNotification::class,
        ],

        'App\Events\CreateUser'     => [
            'App\Listeners\UserCreate',
        ],

        'App\Events\CreateCard'     => [
            'App\Listeners\CardCreate',
        ],

        'App\Events\CreateCardUsa'  => [
            'App\Listeners\CardCreateUsa',
        ],

        'App\Events\CreateContrato' => [
            'App\Listeners\ContratoCreate',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // User::observe(UserObserver::class);
    }
}
