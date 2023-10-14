<?php

namespace App\Listeners;

use App\Notifications\EndpointWentDownNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendDownEmailNotifications
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        collect(explode(',', $event->check->endpoint->site->notification_emails))->each(function ($email) use ($event) {
            Notification::route('mail', $email)
                ->notify(new EndpointWentDownNotification($event->check->endpoint));
        });
    }
}
