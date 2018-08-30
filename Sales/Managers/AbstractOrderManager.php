<?php


namespace Laragento\Sales\Managers;

use Laragento\Quote\DataObjects\QuoteSessionItem;
use Laragento\Quote\DataObjects\QuoteSessionObject;
use Laragento\Sales\Models\Order;
use Laragento\Sales\Models\Order\Address;
use Laragento\Sales\Models\Order\Item;
use Laragento\Sales\Repositories\OrderItemRepository;
use Laragento\Sales\Repositories\OrderRepository;

abstract class AbstractOrderManager
{
    protected $orderItemRepository;
    protected $orderRepository;

    const ORDER_STATE_NEW = "new";
    const ORDER_STATUS_PENDING = "pending";

    public function __construct(
        OrderRepository $orderRepository,
        OrderItemRepository $orderItemRepository
    ) {
        $this->orderItemRepository = $orderItemRepository;
        $this->orderRepository = $orderRepository;
    }

    abstract protected function mapQuoteToOrder($quote);

    /**
     * @param QuoteSessionObject $quote
     * @return mixed
     */
    public function saveOrderFromQuote($quote)
    {
        $orderData = $this->mapQuoteToOrder($quote);
        $order = $this->orderRepository->store($orderData);
        $this->saveItems($quote, $order);
        $this->saveAddresses($quote,$order);
        // This save Grid
        // This save payment
        return $order;
    }

    protected function mapQuoteItemToOrderItem(QuoteSessionItem $item, $order)
    {
        return [
            'order_id' => $order->entity_id,
            'parent_item_id' => null,
            'quote_item_id' => $item->item_id,
            'store_id' => $item->store_id,
            'product_id' => $item->product_id,
            'product_type' => $item->product()->type,
            'product_options' => $item->product()->options,
            'weight' => $item->getWeight(),
            'is_virtual' => 0, // ToDo
            'sku' => $item->sku,
            'name' => $item->name,
            'description' => $item->description,
            'applied_rule_ids' => null, // ToDo
            'additional_data' => null, // ToDo
            'is_qty_decimal' => 0,
            'no_discount' => 0,
            //'qty_backordered' => 0,
            //'qty_canceled' => 0,
            //'qty_invoiced' => 0,
            'qty_ordered' => $item->qty,
            //'qty_refunded' => 0,
            //'qty_shipped' => 0,
            'base_cost' => null,
            'price' => $item->price,
            'base_price' => $item->base_price,
            'original_price' => $item->product()->price,
            'base_original_price' => $item->product()->price, // ToDo
            'tax_percent' => $item->tax_percent,
            'tax_amount' => $item->tax_amount,
            'base_tax_amount' => $item->base_tax_amount,
            'discount_percent' => $item->discount_percent,
            'discount_amount' => $item->discount_amount,
            'base_discount_amount' => $item->base_discount_amount,
            'row_total' => $item->row_total,
            'base_row_total' => $item->base_row_total,
            'row_weight' => $item->row_weight,
            'base_tax_before_discount' => $item->base_tax_amount, // ToDo
            'tax_before_discount' => $item->base_tax_amount, // ToDo
            'ext_order_item_id' => null,
            'locked_do_invoice' => null,
            'locked_do_ship' => null,
            'price_incl_tax' => $item->price_incl_tax,
            'base_price_incl_tax' => $item->base_price_incl_tax,
            'row_total_incl_tax' => $item->row_total_incl_tax,
            'base_row_total_incl_tax' => $item->base_row_total_incl_tax,
            'free_shipping' => $item->free_shipping,
        ];
    }

    /**
     * @param $orderId
     * @param $address
     * @return array
     */
    protected function mapQuoteAddressToOrderAddress($orderId, $address)
    {
        return [
            'parent_id' => $orderId,
            'customer_address_id' => NULL,  // ToDo
            'quote_address_id' => NULL, // ToDo
            'region_id' => $address->region_id,
            'customer_id' => $address->customer_id,
            'fax' => $address->fax,
            'region' => $address->region,
            'postcode' => $address->postcode,
            'lastname' => $address->lastname,
            'street' => $address->street,
            'city' => $address->city,
            'email' => $address->email,
            'telephone' => $address->telephone,
            'country_id' => $address->country_id,
            'firstname' => $address->firstname,
            'address_type' => $address->address_type,
            'prefix' => $address->prefix,
            'middlename' => $address->middlename,
            'suffix' => $address->suffix,
            'company' => $address->company,
            'vat_id' => $address->vat_id,
            'vat_is_valid' => $address->vat_is_valid,
            'vat_request_id' => $address->vat_request_id,
            'vat_request_date' => $address->vat_request_date,
            'vat_request_success' => $address->vat_request_success
        ];
    }

    /**
     * Stores quote items to order items
     * @param QuoteSessionObject $quote
     * @param $order
     */
    protected function saveItems(QuoteSessionObject $quote, $order): void
    {
        foreach ($quote->getItems() as $item) {
            $itemData = $this->mapQuoteItemToOrderItem($item, $order);
            Item::create($itemData);
        }
    }

    /**
     * @param Order $order
     * @param $quote
     */
    protected function saveAddresses(QuoteSessionObject $quote, Order $order)
    {
        $billingAddress = null;
        $shippingAddress = null;
        $addresses = $quote->getAddresses();
        foreach ($addresses as $address) {
            if ($address->address_type  == 'billing') {
                $billingAddress = $this->mapQuoteAddressToOrderAddress(
                    $order->entity_id,
                    $address);
            }
            if ($address->address_type  == 'shipping') {
                $shippingAddress = $this->mapQuoteAddressToOrderAddress(
                    $order->entity_id,
                    $address);
            }
        }

        Address::create($billingAddress);
        Address::create($shippingAddress);
    }


    /**
     * @return string
     */
    protected function incrementId()
    {
        /** @var Order $lastOrder */
        $lastOrder = Order::orderBy('increment_id', 'desc')->first();
        $lastOrderIncrement = $lastOrder ? $lastOrder->increment_id : 0;
        return str_pad(((int)$lastOrderIncrement + 1), 9, 0, STR_PAD_LEFT);
    }

    /**
     * @return string
     */
    protected function protectCode()
    {
        return substr(md5(uniqid(mt_rand(), true) . ':' . microtime(true)), 5, 6);
    }
}