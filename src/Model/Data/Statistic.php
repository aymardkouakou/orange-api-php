<?php

namespace AymardKouakou\OrangeApiPhp\Model\Data;

class Statistic
{
    public ?string $service = null;
    /** @var ServiceStatistic[] */
    public array $serviceStatistics = [];

    public function __construct(array $args = [])
    {
        $this->service = $args['service'] ?? null;

        if (!empty($args['serviceStatistics']) && is_array($args['serviceStatistics'])) {
            foreach ($args['serviceStatistics'] as $serviceStatistic) {
                $this->serviceStatistics[] = new ServiceStatistic($serviceStatistic);
            }
        }
    }
}