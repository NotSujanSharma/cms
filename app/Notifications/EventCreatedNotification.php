<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventCreatedNotification extends Notification
{
    use Queueable;

    protected $event;
    protected $subadmin;

    public function __construct($event, $subadmin)
    {
        $this->event = $event;
        $this->subadmin = $subadmin;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->subadmin->name . ' has created a new event: ' . $this->event->name,
            'event_id' => $this->event->id,
            'subadmin_id' => $this->subadmin->id,
            'type' => 'event_created'
        ];
    }
}
