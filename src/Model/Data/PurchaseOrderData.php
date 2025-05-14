<?php

namespace AymardKouakou\OrangeApiPhp\Model\Data;

class PurchaseOrderData
{
    public ?string $id = null;
    public ?string $developerId = null;
    public ?string $contractId = null;
    public ?string $country = null;
    public ?string $offerName = null;
    public ?string $bundleId = null;
    public ?string $bundleDescription = null;
    public ?int $price = null;
    public ?string $currency = null;
    public ?string $purchaseDate = null;
    public ?string $paymentMode = null;
    public ?string $paymentProviderOrderId = null;
    public ?string $payerId = null;
    public ?string $type = null;
    public ?int $oldAvailableUnits = null;
    public ?int $newAvailableUnits = null;
    public ?string $oldExpirationDate = null;
    public ?string $newExpirationDate = null;
    public ?string $externalId = null;
    public ?string $comment = null;

    public function __construct(array $args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}