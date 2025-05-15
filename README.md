# orange-api-php

**orange-api-php** est une bibliothèque PHP pour interagir avec l'API Orange (SMS, balance, statistiques, historique d'achats, etc.).

## Fonctionnalités principales

- Authentification OAuth2 auprès de l'API Orange
- Envoi de SMS à un ou plusieurs destinataires
- Consultation du solde (balance)
- Récupération des statistiques partenaires
- Consultation de l’historique des achats
- Gestion centralisée des logs

## Installation

Utilisez [Composer](https://getcomposer.org/) :

```sh
composer require aymardk/orange-api-php
```

## Configuration

Créez un fichier `.env` à la racine du projet avec les variables suivantes :

```
APP_ID=VotreAppId
CLIENT_ID=VotreClientId
CLIENT_SECRET=VotreClientSecret
SENDER_ADDRESS=VotreNuméroExpéditeur
MESSAGE_LOG_PATH=log
LOG_PATH=tmp
TEST_ADDRESS_1=NuméroTest1
TEST_ADDRESS_2=NuméroTest2
```

Assurez-vous que les dossiers `log` et `tmp` existent et sont accessibles en lecture/écriture.

## Utilisation

### Authentification

```php
use AymardKouakou\OrangeApiPhp\Core\Authorization;

$auth = new Authorization($clientId, $clientSecret, $logPath);
```

### Envoi de SMS

```php
use AymardKouakou\OrangeApiPhp\Feature\SMSMessage;

$sms = new SMSMessage($auth, $messageLogPath);
if ($sms->isAuthorized()) {
    $response = $sms
        ->withSenderAddress($senderAddress)
        ->withAddress('NuméroDestinataire')
        ->send('Votre message ici');
}
```

### Consultation du solde

```php
use AymardKouakou\OrangeApiPhp\Feature\Balance;

$balance = new Balance($auth, $messageLogPath);
if ($balance->isAuthorized()) {
    $response = $balance->check('CIV');
    $availableUnits = $response->balance->availableUnits;
}
```

### Statistiques partenaires

```php
use AymardKouakou\OrangeApiPhp\Feature\Statistics;

$stats = new Statistics($auth, $messageLogPath);
if ($stats->isAuthorized()) {
    $response = $stats->check('CIV', $appId);
}
```

### Historique des achats

```php
use AymardKouakou\OrangeApiPhp\Feature\PurchaseHistory;

$orders = new PurchaseHistory($auth, $messageLogPath);
if ($orders->isAuthorized()) {
    $response = $orders->check('CIV');
}
```

## Tests

Les tests unitaires sont écrits avec PHPUnit. Pour les lancer :

```sh
vendor/bin/phpunit tests/
```

Les tests couvrent :
- La validité des credentials et de la configuration
- L’envoi de SMS (avec plusieurs destinataires)
- La récupération du solde, des statistiques et de l’historique d’achats
- L’hydratation des objets de données

## Structure du projet

```
.
├── src/
│   ├── Core/
│   ├── Feature/
│   └── Model/
├── tests/
├── log/
├── tmp/
├── .env
├── composer.json
└── README.md
```

## Contribution

Les contributions sont les bienvenues ! Merci d’ouvrir une issue ou une pull request.

## Licence

MIT

---

© 2024 AymardKouakou