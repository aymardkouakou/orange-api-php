<?php

namespace AymardKouakou\OrangeApiPhp\Model\Response;

use AymardKouakou\OrangeApiPhp\Model\Data\OutboundSMSMessageRequest;

class SMSMessageResponse
{
    public ?OutboundSMSMessageRequest $outboundSMSMessageRequest = null;

    public function __construct(array $args = [])
    {
        if (!empty($args['outboundSMSMessageRequest'])) {
            $this->outboundSMSMessageRequest = new OutboundSMSMessageRequest($args['outboundSMSMessageRequest']);
        }
    }
}