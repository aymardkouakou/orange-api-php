<?php

namespace AymardKouakou\OrangeApiPhp\Model\Data;

class PartnerStatisticData
{
    public ?string $partnerId = null;
    public ?string $developerId = null;
    /** @var Statistic[]|null */
    public ?array $statistics = null;

    public function __construct(array $args = [])
    {
        $this->partnerId = $args['partnerId'] ?? null;
        $this->developerId = $args['developerId'] ?? null;

        if (!empty($args['statistics']) && is_array($args['statistics'])) {
            $this->statistics = [];
            foreach ($args['statistics'] as $statistic) {
                $this->statistics[] = new Statistic($statistic);
            }
        }
    }
}