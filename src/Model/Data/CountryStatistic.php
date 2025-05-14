<?php

namespace AymardKouakou\OrangeApiPhp\Model\Data;

class CountryStatistic
{
    public ?string $appid = null;
    public ?string $applicationId = null;
    public ?int $usage = null;
    public ?int $nbEnforcements = null;

    public function __construct(array $args = [])
    {
        foreach (['appid', 'applicationId', 'usage', 'nbEnforcements'] as $key) {
            if (array_key_exists($key, $args)) {
                $this->$key = $args[$key];
            }
        }
    }
}