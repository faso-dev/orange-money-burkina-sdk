# sdk orange-money-burkina  

SDK non officiel de l'API de base de Orange Money Burkina
afin de faciliter son usage et son intégration par les développeurs
dans des projets PHP.  

## Installation via composer

```shell
composer require faso-dev/orange-money-burkina-sdk
```

## Cas d'utilisation

```php

use Fasodev\Sdk\Config\TransactionData;
use Fasodev\Sdk\Exception\TransactionException;
use Fasodev\Sdk\OrangeMoneyAPI;
use Fasodev\Sdk\PaymentSDK;

require_once __DIR__ . '/vendor/autoload.php';

try {
    $orangeApi = (new OrangeMoneyAPI("username", "password", "merchant_number"))
                ->withTransactionData(TransactionData::from('client_number', 'payment_amount', 'otp_code'))
                ->withCustomReference("123456778") //optionnal
                ->useProdApi() // for production
                ->withoutSSLVerification() //if you have any troubleshoot with ssl verifcation(not recommended)
    ;
    $response = (new PaymentSDK($orangeApi))->handlePayment();
    echo 'Thank you for your purchasse !';
    echo $response->getTransactionId();
} catch (TransactionException $exception) {
    echo "Whoops! Unable to process payment. <br/> 
          Error message returned by request: {$exception->getMessage()}. <br/>
          Error code returned by request: {$exception->getCode()}";
}
```

## Testing

Exécutez les tests avec:

```bash
vendor/bin/phpunit
```

ou

```bash
composer tests
```

## Authors

- https://github.com/faso-dev 
- https://github.com/yenteck 

Merci de contribuer !
