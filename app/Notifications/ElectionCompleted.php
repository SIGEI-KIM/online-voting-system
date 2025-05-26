<?php

namespace App\Notifications;

use App\Models\Election;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ElectionCompleted extends Notification implements ShouldQueue
{
    use Queueable;

    protected $election;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Election  $election
     * @return void
     */
    public function __construct(Election $election)
    {
        $this->election = $election;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Election Completed: ' . $this->election->title)
                    ->line('The election "' . $this->election->title . '" has been automatically marked as completed.')
                    ->line('You can now view the results.')
                    ->action('View Election', route('admin.elections.show', $this->election->id)) // Adjust route as needed
                    ->line('Thank you for using our online voting system!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'election_id' => $this->election->id,
            'election_title' => $this->election->title,
            'message' => 'The election "' . $this->election->title . '" has been completed.',
            'url' => route('admin.elections.show', $this->election->id), // Adjust route as needed
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}