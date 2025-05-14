<?php

namespace AymardKouakou\OrangeApiPhp\Model\Data;

class OutboundSMSTextMessage
{
    public ?string $message = null;

    public function __construct(array $args = [])
    {
        if (array_key_exists('message', $args)) {
            $this->message = $args['message'];
        }
    }
}