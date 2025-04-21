<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentSuccessful extends Notification implements ShouldQueue
{
    use Queueable;

    protected $payment;
    protected $request;

    /**
     * Create a new notification instance.
     */
    public function __construct($payment, $request)
    {
        $this->payment = $payment;
        $this->request = $request;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail']; // Send via email
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Payment Successful')
            ->line("Your payment of ₱" . number_format($this->payment->amount, 2) . " for {$this->request->service->name} has been received.")
            ->line('Your request is now being processed.')
            ->line("Reference Number: {$this->payment->reference_number}")
            ->action('View Your Request', route('requests.show', $this->request))
            ->line('Thank you for using our service!');
    }
}
