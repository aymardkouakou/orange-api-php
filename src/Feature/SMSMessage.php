<?php

namespace AymardKouakou\OrangeApiPhp\Feature;

use AymardKouakou\OrangeApiPhp\Core\Authorization;
use AymardKouakou\OrangeApiPhp\Core\Endpoints;
use AymardKouakou\OrangeApiPhp\Core\Requests;
use AymardKouakou\OrangeApiPhp\Model\Response\SMSMessageResponse;

class SMSMessage extends OrangeApi
{
    protected ?string $address = null;
    protected ?string $senderName = null;
    protected ?string $senderAddress = null;

    private array $request = [];

    public function __construct(Authorization $authorization, ?string $logPath = null)
    {
        parent::__construct($authorization, $logPath);
    }

    /**
     * Prépare et exécute la requête d'envoi de SMS.
     * 
     * @param array $args
     * @return array
     * @throws \Exception
     */
    protected function query(array $args): array
    {
        $this->request = [
            'senderAddress' => "tel:+$this->senderAddress",
            'address' => "tel:+$this->address",
            'outboundSMSTextMessage' => [
                'message' => $args['message']
            ]
        ];

        if ($this->senderName !== null) {
            $this->request['senderName'] = $this->senderName;
        }

        $data = [
            'outboundSMSMessageRequest' => $this->request
        ];

        return Requests::call(
            [
                'Authorization' => $this->authorization->getTokenType() . ' ' . $this->authorization->getAccessToken(),
            ],
            'post',
            Endpoints::getSmsMessaging($this->senderAddress),
            $data,
            $this->logger
        );
    }

    public function withAddress(string $address): self
    {
        $this->address = $address;
        return $this;
    }

    public function withSenderAddress(string $senderAddress): self
    {
        $this->senderAddress = $senderAddress;
        return $this;
    }

    public function withSenderName(string $senderName): self
    {
        $this->senderName = $senderName;
        return $this;
    }

    /**
     * @param string $message
     * @return SMSMessageResponse
     * @throws \Exception
     */
    public function send(string $message): SMSMessageResponse
    {
        if ($this->address === null || $this->senderAddress === null) {
            throw new \RuntimeException('address and senderAddress must be provided.');
        }

        $result = $this->attempt(['message' => $message], 201);
        return new SMSMessageResponse($result ?? []);
    }
}