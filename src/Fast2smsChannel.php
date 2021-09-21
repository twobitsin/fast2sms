<?php

namespace TwoBitsIn\Fast2sms;

use Illuminate\Notifications\Notification;
use TwoBitsIn\Fast2sms\Fast2smsClient;

class Fast2smsChannel
{
    protected $Fast2smsClient;
    public function __construct(Fast2smsClient $Fast2smsClient)
    {
        $this->Fast2smsClient = $Fast2smsClient;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \TwoBitsIn\Fast2sms\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('fast2sms', $notification)) {
            return;
        }
        $toArray = [];
        if(is_array($to)){
            $toArray = $to;
        }
        if(is_string($to)){
            array_push($toArray,$to);
        }
        $content = $notification->toFast2sms($notifiable);
        if(empty($toArray)){
            array_push($toArray,$content['payload']['to']);
        }

        return $this->Fast2smsClient->send($content['payload']['messageId'],$content['payload']['variable_values'],$toArray);

        
    }
}
