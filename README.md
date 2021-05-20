# sdk orange-money-burkina   
SDK non officiel de l'API de base de Orange Money Burkina
afin de faciliter son usage et son intégration par les développeurs
dans des projets PHP.  

**Installation via composer**
```shell
composer require faso-dev/orange-money-burkina-sdk v1.alpha
```
**Cas d'utilisation**

```php

    use Fasodev\Exceptions\PaymentSDKException;
    use Fasodev\Sdk\PaymentSDK;
    use \Fasodev\Sdk\OrangeMoneyAPI;

    require_once __DIR__ . '/../vendor/autoload.php';
    
    try {
        $orangeMoneyAPI = new OrangeMoneyAPI(
            "username",
            "password",
            "merchantNumber",
            OrangeMoneyAPI::ENV_DEV
        );
    
        $orangeMoneyAPI->setAmount(1000) // Montant de la transaction
            ->setOTPCode(121212) // Code otp fourni par l'utilisateur
            ->setClientNumber(76819212); // Le numero de client
    
        $sdk = new PaymentSDK($orangeMoneyAPI);
    
        $result = $sdk->handlePayment(); //Enclenchement du processus de paiement
    
        echo " paiement effectué";
        echo $result->transID;
    
    } catch (PaymentSDKException $exception) {
        echo "Whoops! Unable to process payment. <br /> Error message returned by request: {$exception->getMessage()}. <br /> Error code returned by request: {$exception->getCode()}";
    }
```
**Authors**
https://github.com/faso-dev 
https://github.com/yenteck 

Merci de contribuer !
