<?php

namespace AymardKouakou\OrangeApiPhp\Model\Response;

use AymardKouakou\OrangeApiPhp\Model\Data\PurchaseOrderData;

class PurchaseOrderResponse
{
    /** @var PurchaseOrderData[] */
    public array $purchaseOrders = [];

    public function __construct(array $args = [])
    {
        foreach ($args as $arg) {
            $purchaseOrder = new PurchaseOrderData();
            foreach ($arg as $key => $value) {
                if (property_exists($purchaseOrder, $key)) {
                    $purchaseOrder->$key = $value;
                }
            }
            $this->purchaseOrders[] = $purchaseOrder;
        }
    }
}