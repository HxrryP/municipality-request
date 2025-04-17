<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toSms')) {
            throw new \Exception('Notification does not have toSms method.');
        }
        
        $message = $notification->toSms($notifiable);
        
        if (empty($notifiable->mobile_number)) {
            return;
        }
        
        // In a real application, you would integrate with an SMS provider like Twilio, Nexmo, etc.
        // For this example, we'll just log the message
        
        Log::info('SMS would be sent to ' . $notifiable->mobile_number . ' with message: ' . $message);
        
        // Example Twilio integration:
        /*
        Http::post('https://api.twilio.com/2010-04-01/Accounts/' . config('services.twilio.sid') . '/Messages.json', [
            'From' => config('services.twilio.from'),
            'To' => $notifiable->mobile_number,
            'Body' => $message,
        ])->throw();
        */
    }
}