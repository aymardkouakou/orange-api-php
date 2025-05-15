<?php

namespace AymardKouakou\OrangeApiPhp\Feature;

use AymardKouakou\OrangeApiPhp\Core\Authorization;
use AymardKouakou\OrangeApiPhp\Core\Endpoints;
use AymardKouakou\OrangeApiPhp\Core\Requests;
use AymardKouakou\OrangeApiPhp\Model\Response\PurchaseOrderResponse;

class PurchaseHistory extends OrangeApi
{
    public function __construct(Authorization $authorization, ?string $logPath = null)
    {
        parent::__construct($authorization, $logPath);
    }

    /**
     * @throws \Exception
     */
    protected function query(array $args): array
    {
        $data = [];
        if (array_key_exists('country_code', $args)) {
            $data += ['country' => $args['country_code']];
        }

        return Requests::call(
            ['Authorization' => $this->authorization->getTokenType() . ' ' . $this->authorization->getAccessToken()],
            'get',
            Endpoints::getPurchaseOrders(),
            $data,
            $this->logger
        );
    }

    /**
     * @param string|null $country_code
     * @return PurchaseOrderResponse
     * @throws \Exception
     */
    public function check(?string $country_code = null): PurchaseOrderResponse
    {
        return
            new PurchaseOrderResponse(
                $this->attempt(['country_code' => $country_code], 200)
            );
    }
}