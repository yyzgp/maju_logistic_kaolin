<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendDONotification extends Notification
{
    use Queueable;
    public $task;
    public $pdf;
    public $merchant;
    /**
     * Create a new notification instance.
     */
    public function __construct($task, $pdf, $merchant)
    {
        $this->task = $task;
        $this->pdf = $pdf;
        $this->merchant = $merchant;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('Welcome '.$this->merchant->name)
                    ->line('Thank you for completing the task successfully with Logisticss!')
                    ->line('Please find the Delivery Order for the completed task in the attacchment of this email.')
                    ->line('Delivery Order No. F0000'.$this->task->id)
                    ->attachData($this->pdf, 'DO-F0000'.$this->task->id.'.pdf');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
