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
    protected $orangeMoneyAPI;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orangeMoneyAPI = new OrangeMoneyAPI(
            env('ORANGE_MONEY_USERNAME'),
            env('ORANGE_MONEY_PASSWORD'),
            env('ORANGE_MONEY_MERCHANT_ID')
        );
    }

    /**
     * @test
     */
    public function canInstantiateWithoutAnError()
    {
        $this->assertInstanceOf(OrangeMoneyAPI::class, $this->orangeMoneyAPI);
    }
}
