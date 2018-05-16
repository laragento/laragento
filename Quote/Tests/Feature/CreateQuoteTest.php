<?php

namespace Laragento\Quote\Tests\Feature;

use Illuminate\Support\Facades\Session;
use Laragento\Quote\Tests\QuoteTestCase;

class CreateQuoteTest extends QuoteTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function an_authenticated_user_can_create_a_quote()
    {
        print_r("\r\n".__FUNCTION__ . "\r\n*******************\r\n");

        // We have a signedin customer
        $this->actingAs($this->customer);

        // we create a shopping cart via API
        $this->post('/v1/quote', []);

        // We verify the cartentry is in the session
        $this->assertTrue(Session::exists('laragento_cart'));

    }

    /**
     * @test
     */
    public function an_unauthenticated_user_cannot_create_a_quote()
    {
        print_r("\r\n".__FUNCTION__ . "\r\n*******************\r\n");

        $this->post('/v1/quote', [])->assertRedirect('/login');

    }

    public function tearDown()
    {

        parent::tearDown();
    }

}
