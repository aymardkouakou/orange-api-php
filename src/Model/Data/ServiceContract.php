<?php

namespace AymardKouakou\OrangeApiPhp\Model\Data;

class ServiceContract
{
    public ?string $country = null;
    public ?string $service = null;
    public ?int $availableUnits = null;
    public ?string $expires = null;
    public ?string $scDescription = null;

    public function __construct(array $args = [])
    {
        foreach (['country', 'service', 'availableUnits', 'expires', 'scDescription'] as $key) {
            if (array_key_exists($key, $args)) {
                $this->$key = $args[$key];
            }
        }
    }
}