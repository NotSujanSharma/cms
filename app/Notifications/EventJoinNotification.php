<?php
namespace App\Notifications;

use App\Models\User;
use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

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
    public function toMail($notifiable)
    {
        $event = $this->event;
        return (new MailMessage)
            //mail about user join
            ->subject('Event Join Notification')
            ->line($this->user->name . ' has joined ' . $event->name)
            ->action('View Event', url('/events/' . $event->id))
            ->line('Thank you for using our application!');
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