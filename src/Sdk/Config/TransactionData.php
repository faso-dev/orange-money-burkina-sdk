<?php

namespace Fasodev\Sdk\Config;

use Fasodev\Utils\ReferenceGenerator;

class TransactionData
{
    protected string $referenceNumber;

    protected string $clientNumber;

    protected string $paymentAmount;

    protected string $otp;

    protected string $externalReference;

    private function __construct(string $clientNumber, string $paymentAmount, string $otp, string $externalReference)
    {
        $this->otp = $otp;
        $this->paymentAmount = $paymentAmount;
        $this->clientNumber = $clientNumber;
        $this->externalReference = $externalReference;
    }

    public static function from(string $clientNumber, string $paymentAmount, string $otp, string $externalReference): self
    {
        return new self($clientNumber, $paymentAmount, $otp, $externalReference);
    }

    /**
     * @return string
     */
    public function getClientNumber(): string
    {
        return $this->clientNumber;
    }

    /**
     * @param string $clientNumber
     * @return TransactionData
     */
    public function setClientNumber(string $clientNumber): self
    {
        $this->clientNumber = $clientNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentAmount(): string
    {
        return $this->paymentAmount;
    }

    /**
     * @param string $paymentAmount
     * @return TransactionData
     */
    public function setAmount(string $paymentAmount): self
    {
        $this->paymentAmount = $paymentAmount;
        return $this;
    }

    /**
     * @return string
     */
    public function getOtp(): string
    {
        return $this->otp;
    }

    /**
     * @param string $otp
     * @return TransactionData
     */
    public function setOtp(string $otp): self
    {
        $this->otp = $otp;
        return $this;
    }

    /**
     * @return string
     */
    public function getReferenceNumber(): string
    {
        return $this->referenceNumber ?? ReferenceGenerator::token();
    }

    /**
     * @param string $referenceNumber
     * @return TransactionData
     */
    public function setReferenceNumber(string $referenceNumber): TransactionData
    {
        $this->referenceNumber = $referenceNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getExternalReference(): string
    {
        return $this->externalReference;
    }

    /**
     * @param string $externalReference
     */
    public function setExternalReference(string $externalReference): void
    {
        $this->externalReference = $externalReference;
    }
}