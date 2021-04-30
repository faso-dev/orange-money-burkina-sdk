<?php
/**
 * @author Yentema Nadjoari <n.yenteck@gmail.com> ,
 * @author S.C Jerôme ONADJA <jeromeonadja28@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Fasodev\Sdk;


use Fasodev\Utils\Str;
use Fasodev\Utils\Xml;

/**
 * Class OMSDK
 * @package Fasodev\Sdk
 */
class OMSDK implements TransactionInterface
{
    /** @var bool */
    const ENV_PROD = true;
    /** @var bool */
    const ENV_DEV = false;

    /**
     * @var bool
     */
    private $app_env;

    /**
     * Transaction amount
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $otp;
    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $password;
    /**
     * @var
     */
    private $merchantNumber;
    /**
     * @var
     */
    private $clientNumber;
    /**
     * @var
     */
    private $referenceNumber = "";
    /**
     * @var string
     */
    private $api_url_test = "https://testom.orange.bf:9008/payment";
    /**
     * @var string
     */
    private $api_url_prod = "https://apiom.orange.bf:9007/payment";

    public static function init(
        string $username,
        string $password,
        $merchantNumber,
        bool $env = self::ENV_PROD): OMSDK
    {
        return (new self())
            ->setUsername($username)
            ->setMerchantNumber($merchantNumber)
            ->setPassword($password)
            ->setAppMode($env);
    }

    private function requestApi()
    {
        //is production?
        $api_url = $this->isProduction() ?
            $this->api_url_prod :
            $this->api_url_test;
        //check if reference number is set
        if (strlen($this->referenceNumber) === 0)
            $this->referenceNumber = Str::generateRandomString();

        $xml = "<?xml version='1.0' encoding='UTF-8'?>
        <COMMAND>
            <TYPE>OMPREQ</TYPE>
            <customer_msisdn>{$this->clientNumber}</customer_msisdn>
            <merchant_msisdn>{$this->merchantNumber}</merchant_msisdn>
            <api_username>{$this->username}</api_username>
            <api_password>{$this->password}</api_password>
            <amount>{$this->amount}</amount>
            <PROVIDER>101</PROVIDER>
            <PROVIDER2>101</PROVIDER2>
            <PAYID>12</PAYID>
            <PAYID2>12</PAYID2>
            <otp>{$this->otp}</otp>
            <reference_number>{$this->referenceNumber}</reference_number>
            <ext_txn_id>201500068544</ext_txn_id>
        </COMMAND>";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * @param float $amount
     * @return OMSDK
     */
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @param string $otp
     * @return OMSDK
     */
    public function setOTPCode(string $otp): self
    {
        $this->otp = $otp;
        return $this;
    }

    /**
     * @param string $username
     * @return OMSDK
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return OMSDK
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function processPayment()
    {
        $RQ = $this->requestApi();
        $parsed = Xml::toObject("<response>" . $RQ . "</response>");
        //TODO: hanle errors
        return $parsed;
    }

    /**
     * @return mixed
     */
    public function getMerchantNumber()
    {
        return $this->merchantNumber;
    }

    /**
     * @param mixed $merchantNumber
     * @return OMSDK
     */
    public function setMerchantNumber($merchantNumber): self
    {
        $this->merchantNumber = $merchantNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClientNumber()
    {
        return $this->clientNumber;
    }

    /**
     * @param mixed $clientNumber
     * @return OMSDK
     */
    public function setClientNumber($clientNumber): self
    {
        $this->clientNumber = $clientNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReferenceNumber()
    {
        return $this->referenceNumber;
    }

    /**
     * @param mixed $referenceNumber
     * @return OMSDK
     */
    public function setReferenceNumber($referenceNumber): self
    {
        $this->referenceNumber = $referenceNumber;
        return $this;
    }

    /**
     * @param bool $env
     * @return OMSDK
     */
    private function setAppMode(bool $env): self
    {
        $this->app_env = $env;
        return $this;
    }

    /**
     * @return bool
     */
    public function isProduction(): bool
    {
        return $this->app_env === self::ENV_PROD;
    }


}
