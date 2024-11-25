<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExportEmployeesCompleted extends Notification
{
    use Queueable;

    protected $export;
    /**
     * Create a new notification instance.
     */
    public function __construct($export)
    {
        $this->export = $export;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {

        return (new MailMessage)
            ->subject('Employee Export Completed')
            ->line('Your employee export is ready for download.')
            ->line('The file will be available for 24 hours.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            'export_id' => $this->export->id,
            'filename' => $this->export->filename,
            'status' => 'completed'
        ];
    }
}
