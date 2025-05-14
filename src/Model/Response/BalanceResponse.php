<?php

namespace AymardKouakou\OrangeApiPhp\Model\Response;

use AymardKouakou\OrangeApiPhp\Model\Data\BalanceData;

class BalanceResponse
{
    public ?BalanceData $balance = null;

    public function __construct(array $args = [])
    {
        $this->balance = new BalanceData();

        foreach ($args as $key => $value) {
            if (property_exists($this->balance, $key)) {
                $this->balance->$key = $value;
            }
        }
    }
}