<?php

namespace Laragento\Quote\Tests\Feature;

use Illuminate\Support\Facades\Session;
use Laragento\Quote\Tests\QuoteTestCase;

class ManageQuoteTest extends QuoteTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function an_authenticated_user_can_update_a_quote()
    {
        print_r("\r\n".__FUNCTION__ . "\r\n*******************\r\n");

        // We have a signedin customer
        $this->actingAs($this->customer);

        // We have a cart
        $this->post('/v1/quote');

        $quote = Session::get('laragento_cart');
        $quote['quote_currency_code'] = "EUR";

        // we get the shopping cart via API by ID
        $this->patch('/v1/quote/',$quote);

        $updatedQuote =  Session::get('laragento_cart');
        $this->assertTrue($updatedQuote['quote_currency_code'] == "EUR");

    }

    /**
     * @test
     */
    public function an_unauthenticated_user_cannot_update_any_quote()
    {
        print_r("\r\n".__FUNCTION__ . "\r\n*******************\r\n");

        $this->patch('/v1/quote', [])->assertRedirect('/login');

    }

    /**
     * @test
     */
    public function an_authenticated_user_can_delete_a_quote()
    {
        print_r("\r\n".__FUNCTION__ . "\r\n*******************\r\n");

        // We have a signedin customer
        $this->actingAs($this->customer);

        // We have a cart
        $this->post('/v1/quote');

        // we get the shopping cart via API by ID
        $this->delete('/v1/quote/');

        $this->assertTrue(!Session::has('laragento_cart'));


    }

    /**
     * @test
     */
    public function an_unauthenticated_user_cannot_delete_any_quote()
    {
        print_r("\r\n".__FUNCTION__ . "\r\n*******************\r\n");

        $this->delete('/v1/quote')->assertRedirect('/login');

    }

    public function tearDown()
    {

        parent::tearDown();
    }

}

