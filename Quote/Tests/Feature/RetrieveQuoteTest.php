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
        $result = $this->get('/v1/quote')->decodeResponseJson();
        $this->assertArraySubset(['customer_id' => $this->customer['entity_id']], $result['data']);

    }

    /**
     * @test
     */
    public function an_authenticated_user_can_get_all_quote_items()
    {
        print_r("\r\n".__FUNCTION__ . "\r\n*******************\r\n");

        // We have a signedin customer
        $this->actingAs($this->customer);

        // We have a cart
        $this->post('/v1/quote');

        // We have two items
        $this->post('/v1/quote/item', ['qty' => 5,'product_id' => 1]);
        $this->post('/v1/quote/item', ['qty' => 10,'product_id' => 5]);

        // we get the shopping cart via API by ID
        $this->get('/v1/quote/item')->assertJsonCount(2);
    }

    /**
     * @test
     */
    public function an_authenticated_user_can_get_a_quote_item_by_id()
    {
        print_r("\r\n".__FUNCTION__ . "\r\n*******************\r\n");

        // We have a signedin customer
        $this->actingAs($this->customer);

        // We have a cart
        $this->post('/v1/quote');

        // We have an item
        $itemData = ['qty' => 5, 'product_id' => 1];
        $item = $this->post('/v1/quote/item', $itemData)->decodeResponseJson();

        // we get the shopping cart via API by ID
        $result = $this->get('/v1/quote/item/'.$item['data']['item_id'])->decodeResponseJson();
        $this->assertArraySubset($itemData, $result['data']);
    }

    /**
     * @test
     */
    public function an_authenticated_user_can_get_a_quote_item_by_product_id()
    {
        print_r("\r\n".__FUNCTION__ . "\r\n*******************\r\n");

        // We have a signedin customer
        $this->actingAs($this->customer);

        // We have a cart
        $this->post('/v1/quote');

        // We have an item
        $itemData = ['qty' => 5, 'product_id' => 7];
        $item = $this->post('/v1/quote/item', $itemData)->decodeResponseJson();

        // we get the shopping cart via API by ID
        $result = $this->get('/v1/quote/item/product/'.$item['data']['product_id'])->decodeResponseJson();
        $this->assertArraySubset($itemData, $result['data']);

    }

    /**
     * @test
     */
    public function an_unauthenticated_user_cannot_get_any_item()
    {
        print_r("\r\n".__FUNCTION__ . "\r\n*******************\r\n");

        $this->get('/v1/quote/item/product/99999')->assertRedirect('/login');
        $this->get('/v1/quote/item/99999')->assertRedirect('/login');
        $this->get('/v1/quote/item')->assertRedirect('/login');

    }

    /**
     * @test
     */
    public function an_authenticated_user_can_get_a_product_by_item_id()
    {
        print_r("\r\n".__FUNCTION__ . "\r\n*******************\r\n");

        // We have a signedin customer
        $this->actingAs($this->customer);

        // We have a cart
        $this->post('/v1/quote');

        // We have a product
        $products = $this->get('/v1/category/5/products')->decodeResponseJson()['data']['products'];
        $product = end($products['data']);

        // We have an item
        $itemData = ['qty' => 5, 'product_id' => $product['id']];
        $item = $this->post('/v1/quote/item', $itemData)->decodeResponseJson();

        // we get the shopping cart via API by ID
        $result = $this->get('/v1/quote/item/'.$item['data']['item_id'].'/product')->decodeResponseJson();
        $this->assertArraySubset(['id' => $itemData['product_id']], $result['data']);
    }

    /**
     * @test
     */
    public function an_unauthenticated_user_cannot_get_any_product_by_item_id()
    {
        print_r("\r\n".__FUNCTION__ . "\r\n*******************\r\n");

        $this->get('/v1/quote/item/99999/product')->assertRedirect('/login');

    }

    /**
     * @test
     */
    public function an_unauthenticated_user_cannot_retrieve_any_quote()
    {
        print_r("\r\n".__FUNCTION__ . "\r\n*******************\r\n");

        $this->get('/v1/quote/', [])->assertRedirect('/login');

    }

    public function tearDown()
    {

        parent::tearDown();
    }

}

