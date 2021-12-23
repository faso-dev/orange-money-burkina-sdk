<?php

namespace Fasodev\Tests;

use Fasodev\Sdk\OrangeMoneyAPI;
use PHPUnit\Framework\TestCase;

/**
 * Class OrangeMoneyAPITest
 *
 * @package Fasodev\Tests
 */
class OrangeMoneyAPITest extends TestCase
{
    protected OrangeMoneyAPI $orangeMoneyAPI;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orangeMoneyAPI = new OrangeMoneyAPI(
            'username',
            'password',
            'merchant_number'
        );
    }


    public function testWeCanInstanciateAnOrangeApiClass()
    {
        $this->assertInstanceOf(OrangeMoneyAPI::class, $this->orangeMoneyAPI);
    }
}
