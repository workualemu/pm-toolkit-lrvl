<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Task;
use Illuminate\Support\HtmlString;

class TaskAssignment extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public Task $task)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->from('admin@example.com', 'Admin')
                ->subject('New task assignment')
                ->greeting(sprintf('Hello %s!', $notifiable->name))
                ->line(new HtmlString('You are assigned to work on a new task titled "<strong>'. $this->task->title.
                    '</strong>."  Please login to the '.config('app.name'). ' toolkit to continue working on the assignment.'))
                ->action('Visit toolkit', url(config('app.url')));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title'=>"New task assigned",
            'description'=>$this->task->title,
        ];
    }
}
