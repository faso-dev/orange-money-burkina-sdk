<?php

namespace Fasodev\Tests;

use Exception;
use Fasodev\Sdk\Config\TransactionData;
use Fasodev\Sdk\Exception\TransactionException;
use Fasodev\Sdk\OrangeMoneyAPI;
use Fasodev\Sdk\PaymentSDK;
use PHPUnit\Framework\TestCase;

/**
 * Class PaymentSDKTest
 *
 * @package Fasodev\Tests
 */
class PaymentSDKTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }


    public function testHandlePaymentWillTrowTransactionExceptionWithInvalidData()
    {
        $this->expectException(TransactionException::class);
        $orangeApi = (new OrangeMoneyAPI("", "", ""))
            ->withTransactionData(TransactionData::from("00000000", "1000", "124893"))
            ->withCustomReference("124869354")
            ->useDevApi();
        $paymentSDK = new PaymentSDK($orangeApi);
        $paymentSDK->handlePayment();
    }

    public function testHandlePaymentWillReturnTransactionResponse()
    {
        $orangeApi = (new OrangeMoneyAPI("", "", ""))
            ->withTransactionData(TransactionData::from("00000000", "1000", "124893"))
            ->withCustomReference("124869354")
            ->withoutSSLVerification()
            ->useDevApi();
        $paymentSDK = new PaymentSDK($orangeApi);
        $paymentSDK->handlePayment();
    }
}
