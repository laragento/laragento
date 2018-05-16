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
    public function an_authenticated_user_can_update_a_quote_by_cartid()
    {
        print_r("\r\n".__FUNCTION__ . "\r\n*******************\r\n");

        // We have a signedin customer
        $this->actingAs($this->customer);

        // We have a cart
        $quote = [];
        $quote['cart_id'] = 9999;
        $this->post('/v1/quote', ['cart_id' => $quote['cart_id']]);

        $newCartId = 9995;
        $newQuote = Session::get('laragento_cart');
        $newQuote['cart_id'] = $newCartId;

        // we get the shopping cart via API by ID
        $this->patch('/v1/quote/'.$quote['cart_id'],$newQuote)->assertJson(['cart_id' => $newCartId]);

    }

    /**
     * @test
     */
    public function an_unauthenticated_user_cannot_update_any_quote()
    {
        print_r("\r\n".__FUNCTION__ . "\r\n*******************\r\n");

        $this->patch('/v1/quote/9999', [])->assertRedirect('/login');

    }

    /**
     * @test
     */
    public function an_authenticated_user_can_delete_a_quote_by_cartid()
    {
        print_r("\r\n".__FUNCTION__ . "\r\n*******************\r\n");

        // We have a signedin customer
        $this->actingAs($this->customer);

        // We have a cart
        $quote = [];
        $quote['cart_id'] = 9999;
        $this->post('/v1/quote', ['cart_id' => $quote['cart_id']]);

        // we get the shopping cart via API by ID
        $this->delete('/v1/quote/'.$quote['cart_id']);

        $this->assertTrue(!Session::has('laragento_cart'));


    }

    /**
     * @test
     */
    public function an_unauthenticated_user_cannot_delete_any_quote()
    {
        print_r("\r\n".__FUNCTION__ . "\r\n*******************\r\n");

        $this->delete('/v1/quote/9999')->assertRedirect('/login');

    }

    public function tearDown()
    {

        parent::tearDown();
    }

}

