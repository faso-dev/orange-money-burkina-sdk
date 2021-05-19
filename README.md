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

    use Fasodev\Sdk\OMSDK;
    use \Fasodev\Sdk\OrangeMoneyAPI;

    require_once __DIR__ . '/../vendor/autoload.php';

    $processor = new OMSDK(new OrangeMoneyAPI("username", "password", "merchantNumber", OMSDK::ENV_DEV));
    
    $result = $processor->handlePayment(); //Enclenchement du processus de paiement
    
    if ($result->status === 200) {
        echo " paiement effectué";
        echo $result->transID;
    } else {
        echo "<pre>";
            print_r($result);
        echo "</pre>";
        echo $result->message;
    }
```
**Authors**
https://github.com/faso-dev 
https://github.com/yenteck 

Merci de contribuer !
