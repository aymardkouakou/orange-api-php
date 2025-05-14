<?php

namespace AymardKouakou\OrangeApiPhp\Model\Response;

use AymardKouakou\OrangeApiPhp\Model\Data\PartnerContract;

class PartnerContractResponse
{
    public ?PartnerContract $partnerContracts = null;

    public function __construct(array $args = [])
    {
        if (!empty($args['partnerContracts'])) {
            $this->partnerContracts = new PartnerContract($args['partnerContracts']);
        }
    }
}