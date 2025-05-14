<?php

namespace AymardKouakou\OrangeApiPhp\Model\Data;

class ServiceStatistic
{
    public ?string $country = null;
    /** @var CountryStatistic[] */
    public array $countryStatistics = [];

    public function __construct(array $args = [])
    {
        $this->country = $args['country'] ?? null;

        if (!empty($args['countryStatistics']) && is_array($args['countryStatistics'])) {
            foreach ($args['countryStatistics'] as $countryStatistic) {
                $this->countryStatistics[] = new CountryStatistic($countryStatistic);
            }
        }
    }
}