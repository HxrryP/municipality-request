<?php

namespace App\Notifications;

use App\Models\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    protected $request;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $channels = ['mail'];
        
        if (!empty($notifiable->mobile_number)) {
            $channels[] = \App\Notifications\Channels\SmsChannel::class;
        }
        
        return $channels;
    }
    
    /**
     * Get the SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    public function toSms($notifiable)
    {
        return "Your request for {$this->request->service->name} has been submitted. Your tracking number is {$this->request->tracking_number}. Status: " . ucfirst(str_replace('_', ' ', $this->request->status));
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $service = $this->request->service;
        
        $mailMessage = (new MailMessage)
            ->subject('Request Submitted - ' . $this->request->tracking_number)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Thank you for submitting your request for ' . $service->name . '.')
            ->line('Your tracking number is: **' . $this->request->tracking_number . '**')
            ->line('Current status: **' . ucfirst(str_replace('_', ' ', $this->request->status)) . '**');
        
        if ($this->request->status === 'payment_required') {
            $mailMessage->line('Payment is required for this request. Please proceed to the payment page to complete your transaction.')
                ->action('Make Payment', route('payments.show', $this->request));
        } else {
            $mailMessage->line('You can track the status of your request using the link below.')
                ->action('Track Request', route('requests.track', $this->request));
        }
        
        $mailMessage->line('**Request Details:**');
        
        // Add service type specific details
        if (strpos($service->slug, 'business-permit') !== false) {
            $mailMessage->line('Business Name: ' . $this->request->form_data['business_name'] ?? 'N/A');
        } elseif (in_array($service->slug, ['birth-certificate', 'death-certificate'])) {
            $mailMessage->line('Person: ' . $this->request->form_data['person_name'] ?? 'N/A');
        } elseif ($service->slug === 'marriage-certificate') {
            $mailMessage->line('Spouses: ' . 
                ($this->request->form_data['husband_name'] ?? 'N/A') . ' and ' . 
                ($this->request->form_data['wife_name'] ?? 'N/A'));
        }
        
        $mailMessage->line('Processing Time: ' . $service->processing_days . ' day(s)')
            ->line('Thank you for using our online services!');
            
        return $mailMessage;
    }
}