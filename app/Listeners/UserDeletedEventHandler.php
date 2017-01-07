<?php

namespace App\Listeners;

use App\Events\UserDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class UserDeletedEventHandler
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
     * @param  UserDeleted  $event
     * @return void
     */
    public function handle(UserDeleted $event)
    {
        $user = $event->user;
        Log::info("Usuário deletado.", ["ID" => $user->cpf, "Nome" => $user->nome]);
    }
}
