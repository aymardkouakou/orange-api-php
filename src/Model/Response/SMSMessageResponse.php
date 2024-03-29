<?php

namespace Aymardk\OrangeApiPhp\Model\Response;

use Aymardk\OrangeApiPhp\Model\Data\OutboundSMSMessageRequest;

class SMSMessageResponse
{
    public ?OutboundSMSMessageRequest $outboundSMSMessageRequest;

    public function __construct(array $args = [])
    {
        if (array_key_exists('outboundSMSMessageRequest', $args)) {
            $this->outboundSMSMessageRequest = new OutboundSMSMessageRequest($args['outboundSMSMessageRequest']);
        }
    }
}