<?php

namespace AymardKouakou\OrangeApiPhp\Model\Data;

class Contract
{
    public ?string $service = null;
    public ?string $contractDescription = null;
    /** @var ServiceContract[] */
    public array $serviceContracts = [];

    public function __construct(array $args = [])
    {
        $this->service = $args['service'] ?? null;
        $this->contractDescription = $args['contractDescription'] ?? null;

        if (!empty($args['serviceContracts']) && is_array($args['serviceContracts'])) {
            foreach ($args['serviceContracts'] as $sc) {
                $this->serviceContracts[] = new ServiceContract($sc);
            }
        }
    }
}