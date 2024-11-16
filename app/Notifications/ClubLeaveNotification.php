<?php
namespace App\Notifications;

use App\Models\User;
use App\Models\Club;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ClubLeaveNotification extends Notification
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

    public function toArray($notifiable)
    {
        return [
            'message' => $this->user->name . ' has left ' . $this->club->name,
            'user_id' => $this->user->id,
            'club_id' => $this->club->id,
            'type' => 'club_leave'
        ];
    }
}