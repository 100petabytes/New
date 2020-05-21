<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Events\UserRegisteredEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;

class SendWelcomeEmailEvent
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
     * @param  UserRegisteredEvent  $event
     * @return void
     */
    public function handle(UserRegisteredEvent $event)
    {
        // dd($event->user);

        Mail::to($event->user)->send (new WelcomeEmail());
    }
}
