<?php

namespace AymardKouakou\OrangeApiPhp\Model\Data;

class PartnerContract
{
    public ?string $partnerId = null;
    /** @var Contract[] */
    public array $contracts = [];

    public function __construct(array $args = [])
    {
        $this->partnerId = $args['partnerId'] ?? null;

        if (!empty($args['contracts']) && is_array($args['contracts'])) {
            foreach ($args['contracts'] as $contract) {
                $this->contracts[] = new Contract($contract);
            }
        }
    }
}