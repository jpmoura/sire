<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\AuthLoginEventHandler',
        ],
        'Illuminate\Auth\Events\Logout' => [
            'App\Listeners\AuthLogoutEventHandler',
        ],
        'App\Events\NewUserCreated' => [
            'App\Listeners\NewUserCreatedEventHandler'
        ],
        'App\Events\UserDeleted' => [
            'App\Listeners\UserDeletedEventHandler'
        ],
        'App\Events\LoginFailed' => [
            'App\Listeners\LoginFailedEventHandler'
        ],
        'App\Events\LoginErrorEvent' => [
            'App\Listeners\LoginErrorEventHandler'
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
