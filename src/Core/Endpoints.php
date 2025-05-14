<?php

namespace AymardKouakou\OrangeApiPhp\Core;

class Endpoints
{
    private static string $scheme = 'https://';
    private static string $domain = 'api.orange.com';

    private static function getBase(): string
    {
        return self::$scheme . self::$domain;
    }

    public static function getAuthentication(): string
    {
        return self::getApiAuthentication('/oauth/v3/token');
    }

    public static function getApiAuthentication(string $url): string
    {
        return self::getBase() . $url;
    }

    public static function getSmsMessaging(string $phoneNumber): string
    {
        return self::getBase()
            . sprintf(
                "%s/%s/%s",
                '/smsmessaging/v1/outbound', urlencode('tel:+' . $phoneNumber), 'requests'
            );
    }

    public static function getContracts(string $endpoint = '/sms/admin/v1/contracts'): string
    {
        return self::getBase() . $endpoint;
    }

    public static function getStatistics(string $endpoint = '/sms/admin/v1/statistics'): string
    {
        return self::getBase() . $endpoint;
    }

    public static function getPurchaseOrders(string $endpoint = '/sms/admin/v1/purchaseorders'): string
    {
        return self::getBase() . $endpoint;
    }
}