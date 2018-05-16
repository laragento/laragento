<?php

namespace Laragento\Quote\Tests\Feature;

use Laragento\Quote\Tests\QuoteTestCase;

class RetrieveQuoteTest extends QuoteTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function an_authenticated_user_can_get_a_quote_by_cartid()
    {
        print_r("\r\n".__FUNCTION__ . "\r\n*******************\r\n");

        // We have a signedin customer
        $this->actingAs($this->customer);

        // We have a cart
        $quote = [];
        $quote['cart_id'] = 9999;
        $this->post('/v1/quote', ['cart_id' => $quote['cart_id']]);

        // we get the shopping cart via API by ID
        $this->get('/v1/quote/'.$quote['cart_id'])->assertJson(['cart_id' => $quote['cart_id']]);

    }

    /**
     * @test
     */
    public function an_unauthenticated_user_cannot_retrieve_any_quote()
    {
        print_r("\r\n".__FUNCTION__ . "\r\n*******************\r\n");

        $this->get('/v1/quote/9999', [])->assertRedirect('/login');

    }

    public function tearDown()
    {

        parent::tearDown();
    }

}

