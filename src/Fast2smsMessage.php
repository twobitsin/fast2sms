<?php

namespace TwoBitsIn\Fast2sms;

use Illuminate\Support\Arr;

class Fast2smsMessage
{
    protected $payload = [];


    /**
     * Set recipient phone number.
     *
     * @param string $to
     */
    public function to(string $to): self
    {
        $this->payload['to'] = $to;

        return $this;
    }


    /**
     * Set recipient phone number.
     *
     * @param string $messageId
     */
    public function messageId(string $messageId): self
    {
        $this->payload['messageId'] = $messageId;

        return $this;
    }

    /**
     * Set recipient phone number.
     *
     * @param string $variable_values
     */
    public function variable_values(array $variable_values): self
    {
        $this->payload['variable_values'] = $variable_values;

        return $this;
    }

}
