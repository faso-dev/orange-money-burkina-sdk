# sdk orange-money-burkina  

SDK non officiel de l'API de base de Orange Money Burkina
afin de faciliter son usage et son intégration par les développeurs
dans des projets PHP.  

## Installation via composer

```shell
composer require faso-dev/orange-money-burkina-sdk v1.alpha
```

## Cas d'utilisation

```php

    use Fasodev\Exceptions\PaymentSDKException;
    use Fasodev\Sdk\PaymentSDK;
    use \Fasodev\Sdk\OrangeMoneyAPI;

    require_once __DIR__ . '/../vendor/autoload.php';

    // Load .env into the application with the following lines of code.
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
    $dotenv->load();
    
    try {
        $orangeMoneyAPI = new OrangeMoneyAPI(
            env('ORANGE_MONEY_USERNAME'),
            env('ORANGE_MONEY_PASSWORD'),
            env('ORANGE_MONEY_MERCHANT_ID')
        );
    
        $orangeMoneyAPI->setAmount(1000) // Montant de la transaction
            ->setOTPCode(121212) // Code otp fourni par l'utilisateur
            ->setClientNumber(76819212); // Le numero de client
    
        $sdk = new PaymentSDK($orangeMoneyAPI);
    
        $result = $sdk->handlePayment(); //Enclenchement du processus de paiement
    
        echo "paiement effectué";
        echo $result->transID;
    
    } catch (PaymentSDKException $exception) {
        echo "Whoops! Unable to process payment. <br /> Error message returned by request: {$exception->getMessage()}. <br /> Error code returned by request: {$exception->getCode()}";
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

Vous pouvez également exécuter l'exemple de code en procédant comme suit à partir du terminal de commande:

```bash
php -S localhost:8000 -t Examples/
```

N'oubliez pas de faire une copie du fichier `.env.exampe` et renommez-le en` .env`, puis définissez les variables à utiliser pour exécuter la requête comme ceci:

```
APP_ENV=local
ORANGE_MONEY_USERNAME='johndoe'
ORANGE_MONEY_PASSWORD='password'
ORANGE_MONEY_MERCHANT_ID='123456789'
```

...puis visitez `http://localhost:8000/example.php` ou ` http://localhost:8000/example2.php` depuis votre navigateur.

## Authors

- https://github.com/faso-dev 
- https://github.com/yenteck 

Merci de contribuer !
