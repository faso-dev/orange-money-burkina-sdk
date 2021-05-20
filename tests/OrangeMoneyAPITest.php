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

        $this->orangeMoneyAPI = new OrangeMoneyAPI("username", "password", "merchantNumber");
    }

    /**
     * @test
     */
    public function canInstantiateWithoutAnError()
    {
        $this->assertInstanceOf(OrangeMoneyAPI::class, $this->orangeMoneyAPI);
    }
}
