<?php

namespace AymardKouakou\OrangeApiPhp\Model\Data;

class OrderInput
{
    public ?string $type = null;
    public ?string $value = null;

    public function __construct(array $args = [])
    {
        foreach (['type', 'value'] as $key) {
            if (array_key_exists($key, $args)) {
                $this->$key = $args[$key];
            }
        }
    }
}