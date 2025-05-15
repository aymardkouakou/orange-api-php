<?php declare(strict_types=1);

namespace AymardKouakou\OrangeApiPhp\Tests;

use AymardKouakou\OrangeApiPhp\Core\Authorization;
use AymardKouakou\OrangeApiPhp\Feature\Balance;
use AymardKouakou\OrangeApiPhp\Feature\PurchaseHistory;
use AymardKouakou\OrangeApiPhp\Feature\SMSMessage;
use AymardKouakou\OrangeApiPhp\Feature\Statistics;
use AymardKouakou\OrangeApiPhp\Model\Data\BalanceData;
use AymardKouakou\OrangeApiPhp\Model\Data\PartnerStatisticData;
use AymardKouakou\OrangeApiPhp\Model\Data\PurchaseOrderData;
use AymardKouakou\OrangeApiPhp\Model\Response\BalanceResponse;
use AymardKouakou\OrangeApiPhp\Model\Response\PartnerStatisticResponse;
use AymardKouakou\OrangeApiPhp\Model\Response\PurchaseOrderResponse;
use AymardKouakou\OrangeApiPhp\Model\Response\SMSMessageResponse;
use PHPUnit\Framework\TestCase;

class OrangeApiTest extends TestCase
{
    protected string $appId;
    protected string $clientId;
    protected string $clientSecret;
    protected string $senderAddress;
    protected string $messageLogPath;
    protected string $logPath;

    public function setUp(): void
    {
        // Charge les variables d'environnement depuis .env
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $this->appId = $_ENV['APP_ID'] ?? '';
        $this->clientId = $_ENV['CLIENT_ID'] ?? '';
        $this->clientSecret = $_ENV['CLIENT_SECRET'] ?? '';
        $this->senderAddress = $_ENV['SENDER_ADDRESS'] ?? '';
        $this->messageLogPath = $_ENV['MESSAGE_LOG_PATH'] ?? 'log';
        $this->logPath = $_ENV['LOG_PATH'] ?? 'tmp';
    }

    /**
     * @return Authorization
     */
    protected function getAuthorization(): Authorization
    {
        return new Authorization(
            $this->clientId,
            $this->clientSecret,
            $this->logPath
        );
    }

    public function testCredentials(): void
    {
        $this->assertIsString($this->appId, 'appId doit être une chaîne');
        $this->assertIsString($this->clientId, 'clientId doit être une chaîne');
        $this->assertIsString($this->clientSecret, 'clientSecret doit être une chaîne');
        $this->assertIsString($this->senderAddress, 'senderAddress doit être une chaîne');
    }

    public function testLogPath(): void
    {
        $this->assertDirectoryExists($this->logPath, 'Le dossier logPath doit exister');
        $this->assertDirectoryIsReadable($this->logPath, 'Le dossier logPath doit être lisible');
        $this->assertDirectoryIsWritable($this->logPath, 'Le dossier logPath doit être accessible en écriture');
    }

    public function testMessageLogPath(): void
    {
        $this->assertDirectoryExists($this->messageLogPath, 'Le dossier messageLogPath doit exister');
        $this->assertDirectoryIsReadable($this->messageLogPath, 'Le dossier messageLogPath doit être lisible');
        $this->assertDirectoryIsWritable($this->messageLogPath, 'Le dossier messageLogPath doit être accessible en écriture');
    }

    public function testAuthorization(): void
    {
        $this->assertInstanceOf(
            Authorization::class,
            $this->getAuthorization(),
            'L\'instance Authorization n\'a pas été créée correctement'
        );
    }

    public function testAuthorizationTokenTypeAndAccessToken(): void
{
    $auth = $this->getAuthorization();
    $auth->init();
    $this->assertIsString($auth->getAccessToken(), "Le token d'accès doit être une chaîne");
    $this->assertIsString($auth->getTokenType(), "Le type de token doit être une chaîne");
}

    public function testSendMessage(): void
    {
        $message = new SMSMessage($this->getAuthorization(), $this->messageLogPath);
        $this->assertInstanceOf(SMSMessage::class, $message, 'L\'instance SMSMessage n\'a pas été créée');

        $this->assertTrue(
            $message->isAuthorized(),
            'L\'autorisation a échoué, impossible de tester l\'envoi de SMS.'
        );

        $addresses = [$_ENV['TEST_ADDRESS_1'], $_ENV['TEST_ADDRESS_2']];

        foreach ($addresses as $address) {
            $response = $message
                ->withSenderAddress($this->senderAddress)
                ->withAddress($address)
                // ->withSenderName("WEB2SMS")
                ->send("Welcome guy. Juste un test d'envoi");

            $this->assertInstanceOf(
                SMSMessageResponse::class,
                $response,
                'La réponse n\'est pas une instance de SMSMessageResponse'
            );
        }
    }

    public function testBalance(): void
    {
        $balance = new Balance($this->getAuthorization(), $this->messageLogPath);

        $this->assertInstanceOf(
            Balance::class,
            $balance,
            "L'instance Balance n'a pas été créée"
        );

        $this->assertTrue(
            $balance->isAuthorized(),
            "L'autorisation a échoué, impossible de tester la balance."
        );

        $response = $balance->check('CIV');

        $this->assertInstanceOf(
            BalanceResponse::class,
            $response,
            "La réponse n'est pas une instance de BalanceResponse"
        );

        $balanceData = $response->balance;

        $this->assertInstanceOf(
            BalanceData::class,
            $balanceData,
            "La donnée balance n'est pas une instance de BalanceData"
        );

        $this->assertIsString($balanceData->status, "Le status de la balance doit être une chaîne");
        $this->assertIsInt($balanceData->availableUnits, "availableUnits doit être un entier");
    }

    public function testStatistics(): void
    {
        $statistics = new Statistics($this->getAuthorization(), $this->messageLogPath);
        $this->assertInstanceOf(
            Statistics::class,
            $statistics,
            "L'instance Statistics n'a pas été créée"
        );

        $this->assertTrue(
            $statistics->isAuthorized(),
            "L'autorisation a échoué, impossible de tester les statistiques."
        );

        $response = $statistics->check('CIV', $this->appId);

        $this->assertInstanceOf(
            PartnerStatisticResponse::class,
            $response,
            "La réponse n'est pas une instance de PartnerStatisticResponse"
        );

        $partnerStatistics = $response->partnerStatistics;

        $this->assertInstanceOf(
            PartnerStatisticData::class,
            $partnerStatistics,
            "Les données partnerStatistics ne sont pas une instance de PartnerStatisticData"
        );

        $this->assertIsString($partnerStatistics->developerId, "developerId doit être une chaîne");
    }

    public function testPurchaseOrders(): void
    {
        $orders = new PurchaseHistory($this->getAuthorization(), $this->messageLogPath);
        $this->assertInstanceOf(
            PurchaseHistory::class,
            $orders,
            "L'instance PurchaseHistory n'a pas été créée"
        );

        $this->assertTrue(
            $orders->isAuthorized(),
            "L'autorisation a échoué, impossible de tester les commandes d'achat."
        );

        $response = $orders->check('CIV');

        $this->assertInstanceOf(
            PurchaseOrderResponse::class,
            $response,
            "La réponse n'est pas une instance de PurchaseOrderResponse"
        );

        $this->assertThat(
            $response->purchaseOrders,
            self::isType('array'),
            "purchaseOrders doit être un tableau"
        );

        foreach ($response->purchaseOrders as $purchaseOrder) {
            $this->assertInstanceOf(
                PurchaseOrderData::class,
                $purchaseOrder,
                "Un élément de purchaseOrders n'est pas une instance de PurchaseOrderData"
            );
        }
    }

    public function testBalanceDataHydration(): void
    {
        $data = [
            'id' => '1',
            'type' => 'test',
            'developerId' => 'dev',
            'applicationId' => 'app',
            'country' => 'CIV',
            'offerName' => 'offre',
            'availableUnits' => 100,
            'requestedUnits' => 10,
            'status' => 'active',
            'expirationDate' => '2025-12-31',
            'creationDate' => '2024-01-01',
            'lastUpdateDate' => '2024-06-01',
        ];
        $balanceData = new BalanceData($data);
        $this->assertSame('1', $balanceData->id);
        $this->assertSame(100, $balanceData->availableUnits);
        $this->assertSame('active', $balanceData->status);
    }

    public function testPurchaseOrderDataHydration(): void
    {
        $data = [
            'id' => 'PO1',
            'developerId' => 'dev',
            'contractId' => 'C1',
            'country' => 'CIV',
            'offerName' => 'offre',
            'price' => 500,
            'currency' => 'XOF',
            'purchaseDate' => '2024-06-01',
        ];
        $order = new PurchaseOrderData($data);
        $this->assertSame('PO1', $order->id);
        $this->assertSame(500, $order->price);
        $this->assertSame('XOF', $order->currency);
    }

    public function testStatisticsWithEmptyResponse(): void
    {
        $response = new PartnerStatisticResponse([]);
        $this->assertNull($response->partnerStatistics, "partnerStatistics doit être null si vide");
    }
}