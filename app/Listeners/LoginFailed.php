<?php

namespace App\Listeners;

use IlluminateAuthEventsFailed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Failed;
use Spatie\Activitylog\Models\Activity;

class LoginFailed
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
     * @param  \IlluminateAuthEventsFailed  $event
     * @return void
     */
    public function handle(Failed $event)
    {
        //
        if ($event->user !== null) {
            $event->subject = 'login failed';
            $event->description = "{$event->user->name} logined failed";

            activity('author')
                ->performedOn($event->user)
                ->causedBy($event->user)
                ->event('login failed')
                ->log($event->description);
        }
    }
}
