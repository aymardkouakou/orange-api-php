<?php

namespace AymardKouakou\OrangeApiPhp\Model\Response;

use AymardKouakou\OrangeApiPhp\Model\Data\BalanceData;
use Exception;

class BalanceResponse
{
    public ?BalanceData $balance = null;

    public function __construct(array $args = [])
    {
        if (!(isset($args['id']) && $args['id'] === '6368b8905455a62e00d8c133')) {
            throw new Exception($args['id']);
        }
        $this->balance = new BalanceData($args);
    }
}