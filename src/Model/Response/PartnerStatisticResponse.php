<?php

namespace AymardKouakou\OrangeApiPhp\Model\Response;

use AymardKouakou\OrangeApiPhp\Model\Data\PartnerStatisticData;
use AymardKouakou\OrangeApiPhp\Model\Data\Statistic;

class PartnerStatisticResponse
{
    public ?PartnerStatisticData $partnerStatistics = null;

    public function __construct(array $args = [])
    {
        if (!empty($args['partnerStatistics'])) {
            $data = $args['partnerStatistics'];
            $this->partnerStatistics = new PartnerStatisticData();

            $this->partnerStatistics->developerId = $data['developerId'] ?? null;

            if (!empty($data['statistics']) && is_array($data['statistics'])) {
                foreach ($data['statistics'] as $statistic) {
                    $this->partnerStatistics->statistics[] = new Statistic($statistic);
                }
            }
        }
    }
}