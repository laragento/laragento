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
    public function an_authenticated_user_can_get_his_quote()
    {
        print_r("\r\n".__FUNCTION__ . "\r\n*******************\r\n");

        // We have a signedin customer
        $this->actingAs($this->customer);

        // We have a cart
        $this->post('/v1/quote');

        // we get the shopping cart via API by ID
        //$this->get('/v1/quote')->assertJson(['customer_id' => $this->customer['entity_id']]);
        $this->get('/v1/quote')->dump();

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

