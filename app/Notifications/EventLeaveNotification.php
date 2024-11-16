<?php
namespace App\Notifications;

use App\Models\User;
use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class EventLeaveNotification extends Notification
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
            ->subject('User wants to leave the event')
            ->line($this->user->name . ' wants to leave ' . $event->name)
            ->action('View Event', url('/events/' . $event->id))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->user->name . ' has left ' . $this->event->name,
            'user_id' => $this->user->id,
            'event_id' => $this->event->id,
            'status' => 'pending',
            'type' => 'event_leave'
        ];
    }
}