<?php

namespace App\Notifications;

use App\Models\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $statusText = ucfirst(str_replace('_', ' ', $this->request->status));
        
        return (new MailMessage)
            ->subject('Request Status Updated: ' . $this->request->tracking_number)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your request for ' . $this->request->service->name . ' has been updated.')
            ->line('Current status: ' . $statusText)
            ->line($this->getStatusMessage())
            ->action('View Request Details', route('requests.show', $this->request))
            ->line('Thank you for using our services!');
    }

    protected function getStatusMessage()
    {
        switch ($this->request->status) {
            case 'pending':
                return 'Your request is pending review by our staff.';
            case 'processing':
                return 'Your request is now being processed.';
            case 'payment_required':
                return 'Please pay the required fees to proceed with your request.';
            case 'ready_for_pickup':
                return 'Your document is ready for pickup at the municipal office.';
            case 'completed':
                return 'Your request has been completed. Thank you for using our e-services.';
            case 'rejected':
                $reason = $this->request->remarks ?? 'No specific reason provided.';
                return 'Unfortunately, your request has been rejected. Reason: ' . $reason;
            default:
                return '';
        }
    }
}