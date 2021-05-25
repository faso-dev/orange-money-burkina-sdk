<?php
/**
 * @author Yentema Nadjoari <n.yenteck@gmail.com> ,
 * @author S.C Jerôme ONADJA <jeromeonadja28@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Fasodev\Sdk;

use Fasodev\Exceptions\OrangeMoneyAPIException;
use Fasodev\Exceptions\PaymentSDKException;
use Fasodev\Utils\Helpers;

/**
 * Class OrangeMoneyAPI
 * @package Fasodev\Sdk
 */
class OrangeMoneyAPI implements TransactionInterface
{
    /**
     * Transaction amount
     * @var float|int|string
     */
    protected $amount;

    /**
     * @var string
     */
    protected $otp;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var
     */
    protected $merchantNumber;

    /**
     * @var
     */
    protected $clientNumber;

    /**
     * @var
     */
    protected $referenceNumber = "";

    /**
     * @var string
     */
    protected $url;

    /**
     * OrangeMoneyAPI constructor.
     *
     * @param string $username
     * @param string $password
     * @param $merchantNumber
     */
    public function __construct(string $username,
                                string $password,
                                $merchantNumber)
    {
        $this->setUsername($username);
        $this->setMerchantNumber($merchantNumber);
        $this->setPassword($password);
    }

    /**
     * @return mixed
     * @throws PaymentSDKException
     */
    public function processPayment()
    {
        $RQ = $this->requestApi();
        $parsed = Helpers::xmlToObject("<response>" . $RQ . "</response>");

        // Throw an exception if the request returns any status code that is not 200.
        if ($parsed->status != 200) {
            throw new OrangeMoneyAPIException((string) $parsed->message, (int) $parsed->status);
        }

        return $parsed;
    }

    private function requestApi()
    {
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
            <reference_number>{$this->getReferenceNumber()}</reference_number>
            <ext_txn_id>201500068544</ext_txn_id>
        </COMMAND>";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getUrl());
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
     * Set the url to be used to make the API call.
     *
     * @return string
     */
    public function getUrl(): string
    {
        // Default to a test url if non is set.
        return $this->url ?? 'https://testom.orange.bf:9008/payment';
    }

    /**
     * Set the url to be used to make the API call.
     *
     * @param string $url <p>The URL of Orange Money API as of the time this packages was updated was
     * 'https://testom.orange.bf:9008/payment' for testing and 'https://apiom.orange.bf:9007/payment' for production.
     * Calling this method without passing a value will default to the production API url.</p>
     *
     * @return OrangeMoneyAPI
     */
    public function setUrl(string $url = 'https://apiom.orange.bf:9007/payment'): OrangeMoneyAPI
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return float|int|string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float|int|string $amount
     * @return OrangeMoneyAPI
     */
    public function setAmount($amount): self
    {
        $this->amount = $amount;
        return $this;
    }
    /**
     * @param string $otp
     * @return OrangeMoneyAPI
     */
    public function setOTPCode(string $otp): self
    {
        $this->otp = $otp;
        return $this;
    }

    /**
     * @param string $username
     * @return OrangeMoneyAPI
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
     * @return OrangeMoneyAPI
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
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
     * @return OrangeMoneyAPI
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
     * @return OrangeMoneyAPI
     */
    public function setClientNumber($clientNumber): self
    {
        $this->clientNumber = $clientNumber;
        return $this;
    }

    /**
     * Get reference number
     *
     * <p>Generate a random string of six digit if referenceNumber is not set</p>
     *
     * @return mixed
     */
    public function getReferenceNumber(): string
    {
        return trim($this->referenceNumber) !== ''
            ? $this->referenceNumber
            : Helpers::randomString(6);
    }

    /**
     * @param mixed $referenceNumber
     * @return OrangeMoneyAPI
     */
    public function setReferenceNumber($referenceNumber): self
    {
        $this->referenceNumber = $referenceNumber;
        return $this;
    }
}