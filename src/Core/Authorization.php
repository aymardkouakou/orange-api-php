<?php

namespace AymardKouakou\OrangeApiPhp\Core;

use Cake\Http\Client;
use Symfony\Component\Filesystem\Filesystem;

class Authorization
{
    protected string $clientSecret;
    protected string $accessToken;
    protected ?string $tokenType = null;
    protected ?string $clientId = null;
    protected string $logPathName = 'authorize';
    protected string $logPath;

    /**
     * Authorization constructor.
     * @param string $clientId
     * @param string $clientSecret
     * @param string $logPath
     */
    public function __construct(string $clientId, string $clientSecret, string $logPath = 'tmp')
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->logPath = sprintf("%s/%s/%s", $logPath, $clientId, $this->logPathName);
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getLogPath(): string
    {
        return $this->logPath;
    }

    public function getAccessToken(): string
    {
        if ($this->accessToken === null) {
            throw new \RuntimeException('Access token not initialized.');
        }
        return $this->accessToken;
    }

    public function getTokenType(): string
    {
        if ($this->tokenType === null) {
            throw new \RuntimeException('Token type not initialized.');
        }
        return $this->tokenType;
    }

    /**
     * Initialise l'autorisation et récupère le token si besoin.
     * @throws \Exception
     */
    public function init(): bool
    {
        $fs = new Filesystem();

        if (!$this->hasToken($fs)) {
            $client = new Client();
            $result = $client->post(
                Endpoints::getAuthentication(),
                ['grant_type' => 'client_credentials'],
                [
                    'auth' => [
                        'type' => 'basic',
                        'username' => $this->clientId,
                        'password' => $this->clientSecret,
                    ]
                ]
            );

            if (!$result->isSuccess() || !in_array($result->getStatusCode(), [200, 201])) {
                $json = $result->getJson();
                $message = $json['message'] ?? 'Authentication failed';
                throw new \RuntimeException($message);
            }

            $json = $result->getJson();
            if (!isset($json['access_token'], $json['token_type'])) {
                throw new \RuntimeException('access_token or token_type missing in response.');
            }

            $this->accessToken = $json['access_token'];
            $this->tokenType = $json['token_type'];

            $fs->dumpFile($this->logPath, json_encode($json));
        }

        return true;
    }

    /**
     * Vérifie la présence d'un token valide dans le cache.
     */
    private function hasToken(Filesystem $fs): bool
    {
        if ($fs->exists($this->logPath)) {
            $content = file_get_contents($this->logPath);
            if ($content !== false && !empty($content)) {
                $json = json_decode($content, true);
                if (!isset($json['access_token'], $json['token_type'])) {
                    throw new \RuntimeException("access_token/token_type not present.");
                }
                $this->accessToken = $json['access_token'];
                $this->tokenType = $json['token_type'];
                return true;
            }
        }
        return false;
    }
}