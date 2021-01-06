<?php
/**
 * @author Yentema Nadjoari <n.yenteck@gmail.com> ,
 * @author S.C Jerôme ONADJA <jeromeonadja28@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Fasodev\Sdk\OMSDK;

require_once __DIR__ . '/../vendor/autoload.php';

$result = OMSDK::init("username", "password", "merchantNumber", OMSDK::ENV_DEV)
    ->setAmount(1000)//Montant de la transaction
    ->setOTPCode(121212)//Code otp fourni par l'utilisateur
    ->setClientNumber(76819212)//Le numero de client
    ->processPayment()//Enclenchement du processus de paiement
;

if ($result->status === 200) {
    echo " paiement effectuée";
    echo $result->transID;

} else {
    echo "<pre>";
        print_r($result);
    echo "</pre>";
    echo $result->message;
}

