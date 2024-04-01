<?php

namespace Fasodev\Http;



use Fasodev\Sdk\Config\Credentials;
use Fasodev\Sdk\Config\TransactionData;

class RequestBody
{
    public static function from(Credentials $credentials, TransactionData $transactionData): string
    {
        return "<?xml version='1.0' encoding='UTF-8'?>
        <COMMAND>
            <TYPE>OMPREQ</TYPE>
            <customer_msisdn>{$transactionData->getClientNumber()}</customer_msisdn>
            <merchant_msisdn>{$credentials->getMerchant()}</merchant_msisdn>
            <api_username>{$credentials->getUsername()}</api_username>
            <api_password>{$credentials->getPassword()}</api_password>
            <amount>{$transactionData->getPaymentAmount()}</amount>
            <PROVIDER>101</PROVIDER>
            <PROVIDER2>101</PROVIDER2>
            <PAYID>12</PAYID>
            <PAYID2>12</PAYID2>
            <otp>{$transactionData->getOtp()}</otp>
            <reference_number>{$transactionData->getReferenceNumber()}</reference_number>
            <ext_txn_id>{$transactionData->getExternalReference()}</ext_txn_id>
        </COMMAND>";
    }
}