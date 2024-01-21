<?php

namespace App\Listeners;

use IlluminateAuthEventsLogout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Logout;

class LogoutSuccessful
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
     * @param  \IlluminateAuthEventsLogout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        //
        if ($event->user !== null) {
            $event->subject = 'author';
            $event->description = "{$event->user->name} logged out successfully from ip {$event->user->ip}";

            activity($event->subject)
                ->performedOn($event->user)
                ->causedBy($event->user)
                ->event('logout')
                ->log($event->description);
        }
    }
}
