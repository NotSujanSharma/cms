<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\Club;
use App\Models\News;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewsPostedNotification extends Notification
{
    use Queueable;

    protected $news;
    protected $subadmin;
    protected $club;

    public function __construct( News $news, Club $club)
    {
        $this->news = $news;
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
            ->subject('news Creation Notification')
            ->line($this->club->name . ' has created ' . $this->news->headline . ' news')
            ->action('View news', url('/news/' . $this->news->id))
            ->line('Thank you for using our application!');

    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'A news has been posted to ' . $this->club->name . ' club ,' . $this->news->headline,
            'news_id' => $this->news->id,
            'club_id' => $this->club->id,
            'type' => 'news_created'
        ];
    }
}
