<?php

namespace App\Listeners;

use App\Events\LoginFailed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class LoginFailedEventHandler
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
     * @param  LoginFailed  $event
     * @return void
     */
    public function handle(LoginFailed $event)
    {
        $credentials = $event->credentials;
        Log::info("Falha no login.", ["Username" => $credentials['username'], "Password" => $credentials['password']]);
    }
}
