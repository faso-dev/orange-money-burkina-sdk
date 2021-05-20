<?php

namespace Fasodev\Tests;

use Fasodev\Sdk\OrangeMoneyAPI;
use Fasodev\Sdk\PaymentSDK;

/**
 * Class PaymentSDKTest
 *
 * @package Fasodev\Tests
 */
class PaymentSDKTest extends TestCase
{
    /**
     * @var PaymentSDK
     */
    private $paymentSDK;

    protected function setUp(): void
    {
        parent::setUp();

        $orangeMoneyApi = $this->createStub(OrangeMoneyAPI::class);

        $this->paymentSDK = new PaymentSDK($orangeMoneyApi);
    }

    /**
     * @test
     */
    public function canInstantiateWithoutAnError()
    {
        $this->assertInstanceOf(PaymentSDK::class, $this->paymentSDK);
    }

    /**
     * @test
     */
    public function hasAttributeTransaction()
    {
        $this->assertClassHasAttribute('transaction',PaymentSDK::class);
    }
}
