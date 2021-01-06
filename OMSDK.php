<?php

/**
 * Class OMSDK
 * @author Yentema Nadjoari<n.yenteck@gmail.com> ,Faso dev <https://github.com/faso-dev>
 * Date 06/01/2021 14H38
 */
namespace Fasodev;

class OMSDK
{

    const MODE_TEST=false;
    const MODE_PROD=true;

    private $api_url_test="https://testom.orange.bf:9008/payment";
    private $api_url_prod="https://orange.bf:9008/payment";

    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $password;
    /**
     * @var string
     */
    private $numeroMarchand;
    /**
     * @var string
     */
    private $numeroClient;
    /**
     * @var integer
     */
    private $montant;
    /**
     * @var string
     */
    private $codeOtp;
    /**
     * @var string
     */
    private $referenceNumber;

    /**
     * @var boolean
     */
    private $isProduction=false;

    static function init($username, $password,$numeroMarchand,$MODE=false){
        $api=new OMSDK();
        $api->setIsProduction($MODE);
        $api->setUsername($username)->setPassword($password)
            ->setNumeroMarchand($numeroMarchand);

        return $api;
    }

    /**
     * effectuer la requête de paiement
     */
    public function processPaiement(){

        //make rq
        $RQ=$this->makeApiCall();
        //parse rq
        $parsed = $this->xmlToObject("<response>".$RQ."</response>");
        //handle errors
        //return response
        return $parsed;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return OMSDK
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return OMSDK
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumeroMarchand()
    {
        return $this->numeroMarchand;
    }

    /**
     * @param string $numeroMarchand
     * @return OMSDK
     */
    public function setNumeroMarchand($numeroMarchand)
    {
        $this->numeroMarchand = $numeroMarchand;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumeroClient()
    {
        return $this->numeroClient;
    }

    /**
     * @param string $numeroClient
     * @return OMSDK
     */
    public function setNumeroClient($numeroClient)
    {
        $this->numeroClient = $numeroClient;
        return $this;
    }

    /**
     * @return int
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * @param int $montant
     * @return OMSDK
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodeOtp()
    {
        return $this->codeOtp;
    }

    /**
     * @param string $codeOtp
     * @return OMSDK
     */
    public function setCodeOtp($codeOtp)
    {
        $this->codeOtp = $codeOtp;
        return $this;
    }

    /**
     * @return string
     */
    public function getReferenceNumber()
    {
        return $this->referenceNumber;
    }

    /**
     * @param string $referenceNumber
     * @return OMSDK
     */
    public function setReferenceNumber($referenceNumber)
    {
        $this->referenceNumber = $referenceNumber;
        return $this;
    }

    /**
     * @return bool
     */
    public function isProduction()
    {
        return $this->isProduction;
    }

    /**
     * @param bool $isProduction
     * @return OMSDK
     */
    public function setIsProduction($isProduction)
    {
        $this->isProduction = $isProduction;
        return $this;
    }


    private function makeApiCall()
    {
        //is production?
        $api_url=$this->isProduction()?$this->api_url_prod:$this->api_url_test;
        //check if reference number is set
        if(strlen($this->referenceNumber)==0)
            $this->referenceNumber= $this->generateRandomString();

        $xml="<?xml version='1.0' encoding='UTF-8'?>
        <COMMAND>
        <TYPE>OMPREQ</TYPE>
        <customer_msisdn>{$this->numeroClient}</customer_msisdn>
        <merchant_msisdn>{$this->numeroMarchand}</merchant_msisdn>
        <api_username>{$this->username}</api_username>
        <api_password>{$this->password}</api_password>
        <amount>{$this->montant}</amount>
        <PROVIDER>101</PROVIDER>
        <PROVIDER2>101</PROVIDER2>
        <PAYID>12</PAYID>
        <PAYID2>12</PAYID2>
        <otp>{$this->codeOtp}</otp>
        <reference_number>{$this->referenceNumber}</reference_number>
        <ext_txn_id>201500068544</ext_txn_id>
        </COMMAND>";

        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $api_url );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $xml );
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function xmlToObject($string){
        $simpleXml = simplexml_load_string($string);
        $json = json_encode($simpleXml);

        return  json_decode($json);
    }

    function generateRandomString($len = 6){
        $charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz.";
        $base = strlen($charset);
        $result = '';

        $now = explode(' ', microtime())[1];
        while ($now >= $base){
            $i = $now % $base;
            $result = $charset[$i] . $result;
            $now /= $base;
        }
        return substr($result, -6);
    }

}