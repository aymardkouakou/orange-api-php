<?php

namespace AymardKouakou\OrangeApiPhp\Feature;

use AymardKouakou\OrangeApiPhp\Core\Authorization;
use AymardKouakou\OrangeApiPhp\Core\Endpoints;
use AymardKouakou\OrangeApiPhp\Core\Requests;
use AymardKouakou\OrangeApiPhp\Model\Response\PartnerStatisticResponse;

class Statistics extends OrangeApi
{
    public function __construct(Authorization $authorization, ?string $logPath = null)
    {
        parent::__construct($authorization, $logPath);
    }

    /**
     * @param $args
     * @return array
     * @throws \Exception
     */
    protected function query(array $args): array
    {
        $data = [];
        if (array_key_exists('country_code', $args)) {
            $data += ['country' => $args['country_code']];
        }
        if (array_key_exists('app_id', $args)) {
            $data += ['appid' => $args['app_id']];
        }

        return Requests::call(
            ['Authorization' => $this->authorization->getTokenType() . ' ' . $this->authorization->getAccessToken()],
            'get',
            Endpoints::getStatistics(),
            $data,
            $this->logger
        );
    }

    /**
     * @param string $country_code
     * @param string|null $app_id
     * @return PartnerStatisticResponse
     * @throws \Exception
     */
    public function check(string $country_code, ?string $app_id = null): PartnerStatisticResponse
    {
        return
            new PartnerStatisticResponse(
                $this->attempt(
                    ['country' => $country_code, 'appid' => $app_id],
                    200
                )
            );
    }
}