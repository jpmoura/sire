<?php

namespace App\Listeners;

use App\Events\LoginErrorEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class LoginErrorEventHandler
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  LoginErrorEvent  $event
     * @return void
     */
    public function handle(LoginErrorEvent $event)
    {
        Log::error("Erro de login", ["motivo" => $event->reason]);
    }
}
