<?php

namespace App\Listeners;

use App\User;
use Illuminate\Auth\Events\Login;
use Log;

class AuthLoginEventHandler
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
    public function handle(Login $event)
    {
        $user = $event->user;
        Log::info("Usuário realizou o login.", ["ID" => $user->cpf, "Nome" => $user->nome, "Lembrar" => $event->remember]);
    }
}