<?php

namespace AymardKouakou\OrangeApiPhp\Model\Data;

class OrderExecutionInformation
{
    public ?string $date = null;
    public ?int $amount = null;
    public ?string $currency = null;
    public ?string $service = null;
    public ?string $country = null;
    public ?string $contractId = null;

    public function __construct(array $args = [])
    {
        foreach (['date', 'amount', 'currency', 'service', 'country', 'contractId'] as $key) {
            if (array_key_exists($key, $args)) {
                $this->$key = $args[$key];
            }
        }
    }
}