<?php

namespace AymardKouakou\OrangeApiPhp\Model\Data;

class BalanceData
{
    public string $id = '';
    public string $type = '';
    public string $developerId = '';
    public ?string $applicationId = null;
    public string $country = '';
    public string $offerName = '';
    public int $availableUnits = 0;
    public int $requestedUnits = 0;
    public string $status = '';
    public string $expirationDate = '';
    public string $creationDate = '';
    public string $lastUpdateDate = '';

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}