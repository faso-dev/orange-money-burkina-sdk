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

    require_once __DIR__ . '/../vendor/autoload.php';

    $orangeMoney = OMSDK::init("username", "password", "merchantNumber", OMSDK::ENV_DEV)
        ->setAmount(1000) //Montant de la transaction
        ->setOTPCode(121212) //Code otp fourni par l'utilisateur
        ->setClientNumber(76819212) //Le numero de client
    ;
    $result = $orangeMoney
        ->processPayment() //Enclenchement du processus de paiement
    ;
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
