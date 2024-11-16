<?php
namespace App\Notifications;

use App\Models\User;
use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class EventJoinNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $event;

    public function __construct(User $user, Event $event)
    {
        $this->user = $user;
        $this->event = $event;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->user->name . ' has joined ' . $this->event->name,
            'user_id' => $this->user->id,
            'club_id' => $this->event->id,
            'type' => 'event_join'
        ];
    }
}