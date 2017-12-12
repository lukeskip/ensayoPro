<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Jenssegers\Date\Date;

class LogSuccessfulLogin
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
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {   
        $companies = $event->user->companies->where('status','paused');
        foreach ($companies as $company) {
            $company->status = 'active';
            $company->save();
        }

        $event->user->last_login = Date::now();
        $event->user->save();
    }
}
