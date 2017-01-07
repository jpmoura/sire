<?php

namespace App\Listeners;

use App\User;
use Illuminate\Auth\Events\Logout;
use Log;

class AuthLogoutEventHandler
{
    /**
     * Cria o Event Listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Registra no login o usuário que realizou o login.
     *
     * @param  PodcastWasPurchased  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $user = $event->user;
        Log::info("Usuário realizou logout.", ["ID" => $user->cpf, "Nome" => $user->nome]);
    }
}