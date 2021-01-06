<?php

use Fasodev\OMSDK;

require "../vendor/autoload.php";

$api=OMSDK::init("eeeee","eeee","75910211");

$api->setMontant(1000)
    ->setCodeOtp(121212)
    ->setNumeroClient(76819212);

$result=$api->processPaiement();

if($result->status==200){
    echo " paiement effectuée";
    echo $result->transID;

}else {
    echo "<pre>";
    print_r($result);
    echo "</pre>";

    echo $result->message;
}

