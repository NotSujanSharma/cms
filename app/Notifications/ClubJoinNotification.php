<?php
namespace App\Notifications;

use App\Models\User;
use App\Models\Club;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ClubJoinNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $club;

    public function __construct(User $user, Club $club)
    {
        $this->user = $user;
        $this->club = $club;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
        //mail about user join
        ->subject('New Club Join Notification')
        ->line($this->user->name . ' has joined ' . $this->club->name)
        ->action('View Club', url('/clubs/' . $this->club->id))
        ->line('Thank you for using our application!');
            
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->user->name . ' has joined ' . $this->club->name,
            'user_id' => $this->user->id,
            'club_id' => $this->club->id,
            'type' => 'club_join'
        ];
    }
}