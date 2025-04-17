<?php

namespace App\Notifications;

use App\Models\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestUpdated extends Notification
{
    use Queueable;

    protected $request;
    protected $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(Request $request, string $message)
    {
        $this->request = $request;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Request Status Updated')
            ->line('Your request has been updated.')
            ->line($this->message)
            ->action('View Request', url(route('requests.show', $this->request)))
            ->line('Thank you for using our services!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'request_id' => $this->request->id,
            'tracking_number' => $this->request->tracking_number,
            'status' => $this->request->status,
            'message' => $this->message,
        ];
    }
}