<?php

namespace Laragento\Quote\Tests\Unit;

use Laragento\Quote\Tests\QuoteTestCase;

class SessionTest extends QuoteTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function hasSession()
    {
        $this->assertTrue(true);
    }

    public function tearDown()
    {

        parent::tearDown();
    }

}


