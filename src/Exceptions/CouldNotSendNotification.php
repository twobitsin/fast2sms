<?php

namespace TwoBitsIn\Fast2sms\Exceptions;

use Exception;
use GuzzleHttp\Exception\ClientException;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($message)
    {
        return new static('Fast2sms Response: '.$message);
    }

    public static function serviceNotAvailable($message): self
    {
        return new static($message);
    }

   /**
     * Thrown when content length is greater than 918 characters.
     *
     * @param $count
     * @return static
     */
    public static function contentLengthLimitExceeded($count): self
    {
        return new static("Notification was not sent. Content length may not be greater than {$count} characters.", 422);
    }

     /**
     * Thrown when we're unable to communicate with fast2sms.
     *
     * @param Exception $exception
     *
     * @return static
     */
    public static function couldNotCommunicateWithFast2sms(Exception $exception): self
    {
        return new static("The communication with fast2sms failed. Reason: {$exception->getMessage()}", $exception->getCode(), $exception);
    }
    
    public static function phoneNumberNotProvided(): self
    {
        return new static('No phone number was provided.');
    }

    public static function envNotset(): self
    {
        return new static('All env variables notset properly');
    }

}
