<?php
/**
 * @author Yentema Nadjoari <n.yenteck@gmail.com> ,
 * @author S.C Jerôme ONADJA <jeromeonadja28@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Fasodev\Exceptions\PaymentSDKException;
use Fasodev\Sdk\OrangeMoneyAPI;
use Fasodev\Sdk\PaymentSDK;

require_once __DIR__ . '/../vendor/autoload.php';

// Load .env into the application with the following lines of code.
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

try {
    $sdk = new PaymentSDK((new OrangeMoneyAPI(
		env('ORANGE_MONEY_USERNAME'),
        env('ORANGE_MONEY_PASSWORD'),
        env('ORANGE_MONEY_MERCHANT_ID'),
        OrangeMoneyAPI::ENV_DEV
    ))
        ->setAmount(1000) // Montant de la transaction
        ->setOTPCode(121212) // Code otp fourni par l'utilisateur
        ->setClientNumber(76819212)); // Le numero de client

    $result = $sdk->handlePayment(); //Enclenchement du processus de paiement

    echo " paiement effectué";
    echo $result->transID;

} catch (PaymentSDKException $exception) {
    echo "Whoops! Unable to process payment. <br /> Error message returned by request: {$exception->getMessage()}. <br /> Error code returned by request: {$exception->getCode()}";
}

