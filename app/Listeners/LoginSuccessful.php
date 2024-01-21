<?php

namespace App\Listeners;

use Carbon\Carbon;
use IlluminateAuthEventsLogin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Spatie\Activitylog\Models\Activity;

class LoginSuccessful
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
     * @param  \IlluminateAuthEventsLogin  $event
     * @return void
     */
    public function handle(Login $event)
    {
        //
        if ($event->user !== null) {
            $event->description = "{$event->user->name} login successfully";


            $event->user->update([
                'ip' => Auth::user()->getUserIpAddr(),
                'logined_at' => now()
            ]);
            activity('author')
                ->performedOn($event->user)
                ->causedBy($event->user)
                ->event('login success')
                ->withProperties(['ip' =>  Auth::user()->getUserIpAddr()])
                ->log($event->description);
        }
    }
}
