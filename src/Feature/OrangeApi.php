<?php

namespace AymardKouakou\OrangeApiPhp\Feature;

use AymardKouakou\OrangeApiPhp\Core\Authorization;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

abstract class OrangeApi
{
    protected ?Logger $logger = null;
    protected ?Authorization $authorization = null;

    public function __construct(Authorization $authorization, ?string $logPath = null)
    {
        $this->authorization = $authorization;

        if ($logPath !== null) {
            $stream = new StreamHandler(
                $logPath . '/sms_reporting_'. gmdate('Ymd') . '.log',
                Logger::DEBUG
            );
            $firephp = new FirePHPHandler();

            $this->logger = new Logger($this->authorization->getClientId());
            $this->logger->pushHandler($stream);
            $this->logger->pushHandler($firephp);
        }
    }

    protected abstract function query(array $args): array;

    /**
     * @throws \Exception
     */
    public function isAuthorized(): bool
    {
        return $this->authorization->init();
    }

    /**
     * @throws \Exception
     */
    protected function attempt(array $args, int $response_code): array
    {
        $callResponse = $this->query($args);

        // Si le code n'est pas celui attendu et qu'il s'agit d'un problème de token (code 42)
        if (array_key_exists('code', $callResponse) && $callResponse['code'] !== $response_code) {
            if ($callResponse['code'] === 42) {
                @unlink($this->authorization->getLogPath());

                if ($this->isAuthorized()) {
                    // On refait UNE SEULE tentative, sans récursion
                    $callResponse = $this->query($args);
                }
            }
        }

        return $callResponse;
    }
}