<?php

namespace Laragento\Quote\Tests\Feature;

use Illuminate\Support\Facades\Session;
use Laragento\Quote\Repositories\QuoteSessionItemRepository;
use Laragento\Quote\Tests\QuoteTestCase;

class ManageQuoteTest extends QuoteTestCase
{

    protected $quoteItemRepository;

    public function setUp()
    {
        parent::setUp();
        $this->quoteItemRepository = $this->app->make(QuoteSessionItemRepository::class);
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

    /**
     * @test
     */
    public function an_authenticated_user_can_add_a_quote_item()
    {
        print_r("\r\n" . __FUNCTION__ . "\r\n*******************\r\n");

        $this->withoutExceptionHandling();

        // We have a signedin customer
        $this->actingAs($this->customer);

        // We have a cart
        $this->post('/v1/quote');

        // We have item data
        $itemData = [
            'qty' => 5,
            'product_id' => 1
        ];

        $this->post('/v1/quote/item', $itemData)->assertStatus(201)->getContent();

        $this->assertTrue(true);

    }

    /**
     * @test
     */
    public function an_authenticated_user_can_update_a_quote_item()
    {
        print_r("\r\n" . __FUNCTION__ . "\r\n*******************\r\n");

        $this->withoutExceptionHandling();

        // We have a signedin customer
        $this->actingAs($this->customer);

        // We have a cart
        $this->post('/v1/quote');

        // We have item data
        $itemData = [
            'qty' => 5,
            'product_id' => 1
        ];
        $newItemData = [
            'qty' => 8
        ];
        $item = $this->post('/v1/quote/item', $itemData)->decodeResponseJson();
        $newItem =  $this->patch('/v1/quote/item/' . $item['item_id'], $newItemData)->decodeResponseJson();

        $this->assertTrue($newItem['qty'] == $newItemData['qty']);
    }

    /**
     * @test
     */
    public function an_authenticated_user_can_delete_a_quote_item()
    {
        print_r("\r\n" . __FUNCTION__ . "\r\n*******************\r\n");
    }

    public function tearDown()
    {

        parent::tearDown();
    }

}

