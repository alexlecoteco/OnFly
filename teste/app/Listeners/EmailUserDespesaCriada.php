<?php

namespace App\Listeners;

use App\Events\DespesaCriada;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmailUserDespesaCriada
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
     * @param  object  $event
     * @return void
     */
    public function handle(DespesaCriada $event)
    {
        $notification = new \App\Notifications\DespesaCriada(
            $event->data,
            $event->valor,
            $event->descricao
        );

        $delay = now()->addSeconds(2);

        $event->user->notify($notification->delay($delay));
    }
}
