<?php

namespace AymardKouakou\OrangeApiPhp\Model\Data;

class OutboundSMSMessageRequest
{
    public ?array $address = null;
    public ?string $senderName = null;
    public ?string $senderAddress = null;
    public ?string $resourceURL = null;
    public ?OutboundSMSTextMessage $outboundSMSTextMessage = null;

    public function __construct(array $args = [])
    {
        foreach (['address', 'senderName', 'senderAddress', 'resourceURL'] as $key) {
            if (array_key_exists($key, $args)) {
                $this->$key = $args[$key];
            }
        }
        if (array_key_exists('outboundSMSTextMessage', $args)) {
            $this->outboundSMSTextMessage = new OutboundSMSTextMessage($args['outboundSMSTextMessage']);
        }
    }
}