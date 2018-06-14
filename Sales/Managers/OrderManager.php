<?php


namespace Laragento\Sales\Managers;

use Laragento\Customer\Repositories\AddressRepositoryInterface;
use Laragento\Quote\DataObject\QuoteSessionItem;
use Laragento\Quote\DataObject\QuoteSessionObject;
use Laragento\Sales\Models\Order;
use Laragento\Sales\Models\Order\Address;
use Laragento\Sales\Models\Order\Item;
use Laragento\Sales\Repositories\OrderItemRepository;
use Laragento\Sales\Repositories\OrderRepository;
use Laragento\Store\Models\Store;

class OrderManager
{
    protected $orderItemRepository;
    protected $orderRepository;
    protected $addressRepository;

    public function __construct(OrderRepository $orderRepository, OrderItemRepository $orderItemRepository, AddressRepositoryInterface $addressRepository)
    {
        $this->orderItemRepository = $orderItemRepository;
        $this->orderRepository = $orderRepository;
        $this->addressRepository = $addressRepository;
    }

    /**
     * @param QuoteSessionObject $quote
     * @return mixed
     */
    public function saveOrderFromQuote($quote)
    {
        $orderData = $this->quoteToOrder($quote);
        $order = $this->orderRepository->store($orderData);
        $this->saveItems($quote, $order);
        $this->saveAddresses($order);
        return $order;
    }

    /**
     * @param QuoteSessionObject $quote
     * @return array
     */
    protected function quoteToOrder($quote)
    {
        $store = Store::whereStoreId($quote->getStoreId())->first();
        return [
            "state" => "new",
            "status" => "pending",
            "coupon_code" => $quote->getCouponCode(),
            "protect_code" => substr(md5(uniqid(mt_rand(), true) . ':' . microtime(true)), 5, 6),
            "shipping_description" => "versandkostenfrei", // ToDo Get from Shippipng Entity
            "is_virtual" => 0,
            "store_id" => $store->store_id,
            "customer_id" => $quote->getCustomerId(),
            "base_discount_amount" => $quote->getBaseSubtotal() - $quote->getBaseSubtotalWithDiscount(),
            "base_grand_total" => $quote->getBaseGrandTotal(),
            "base_subtotal" => $quote->getBaseSubtotal(),
            "base_tax_amount" => "0.0000", //ToDo calculate
            "shipping_amount" => "0.0000", // ToDo Get from Shippipng Entity
            "total_qty_ordered" => $quote->getItemsQty(),
            "customer_is_guest" => 0,
            "billing_address_id" => $quote->customer()->billing['entity_id'],
            "customer_group_id" => $quote->customer()->group['customer_group_id'],
            "email_sent" => 0,
            "send_email" => 1,
            "shipping_address_id" => $quote->customer()->shipping['entity_id'],
            "subtotal_incl_tax" => $quote->getSubtotal(), // ToDo Tax Calculation
            "increment_id" => "",
            "base_currency_code" => $quote->getBaseCurrencyCode(),
            "customer_email" => $quote->customer()->email,
            "customer_firstname" => $quote->customer()->firstname,
            "customer_lastname" => $quote->customer()->lastname,
            "customer_middlename" => $quote->customer()->middlename,
            "customer_prefix" => $quote->customer()->prefix,
            "customer_suffix" => $quote->customer()->suffix,
            "customer_taxvat" => $quote->customer()->taxvat,
            "discount_description" => "", // ToDo make dynamic
            "order_currency_code" => $quote->getQuoteCurrencyCode(),
            "original_increment_id" => "",
            "shipping_method" => "versandkostenfrei", // ToDo make dynamic
            "store_name" => $store->name,
            "customer_note" => "" // ToDo make dynamic
        ];
    }

    protected function quoteItemToOrderItem(QuoteSessionItem $item, $order)
    {
        return [
            'order_id' => $order->entity_id,
            'parent_item_id' => null,
            'quote_item_id' => $item->getItemId(),
            'store_id' => $item->getStoreId(),
            'product_id' => $item->getProductId(),
            'product_type' => $item->product()->type,
            'product_options' => $item->product()->options,
            'sku' => $item->getSku(),
            'name' => $item->getName(),
            'description' => $item->getDescription(),
            'qty_ordered' => $item->getQty(),
            'price' => $item->getPrice(),
            'base_price' => $item->getBasePrice(),
            'original_price' => $item->product()->price,
            'base_original_price' => $item->product()->price, // ToDo
            'tax_percent' => $item->getTaxPercent(),
            'tax_amount' => $item->getTaxAmount(),
            'base_tax_amount' => $item->getBaseTaxAmount(),
            'discount_percent' => $item->getDiscountPercent(),
            'discount_amount' => $item->getDiscountAmount(),
            'base_discount_amount' => $item->getBaseDiscountAmount(),
            'row_total' => $item->getRowTotal(),
            'base_row_total' => $item->getBaseRowTotal(),
            'row_weight' => $item->getRowWeight(),
            'base_tax_before_discount' => $item->getBaseTaxAmount(), // ToDo
            'tax_before_discount' => $item->getBaseTaxAmount(), // ToDo
            'ext_order_item_id' => null,
            'locked_do_invoice' => null,
            'locked_do_ship' => null,
            'price_incl_tax' => $item->getPriceInclTax(),
            'base_price_incl_tax' => $item->getBasePriceInclTax(),
            'row_total_incl_tax' => $item->getRowTotalInclTax(),
            'base_row_total_incl_tax' => $item->getBaseRowTotalInclTax(),
            'free_shipping' => $item->getFreeShipping()
        ];
    }

    protected function getAddressData($orderId, $addressId, $type)
    {
        /** @var Address $address */
        $address = $this->addressRepository->first($addressId);

        return [
            'parent_id' => $orderId,
            'customer_address_id' => $addressId,
            'quote_address_id' => $addressId,
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
            'address_type' => $type,
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
     * @param QuoteSessionObject $quote
     * @param $order
     */
    protected function saveItems(QuoteSessionObject $quote, $order): void
    {
        foreach ($quote->getItems() as $item) {
            $itemData = $this->quoteItemToOrderItem($item, $order);
            Item::create($itemData);
        }
    }

    protected function saveAddresses(Order $order)
    {
        $billingdata = $this->getAddressData($order->entity_id, $order->billing_address_id, 'billing');
        $shippingdata = $this->getAddressData($order->entity_id, $order->shipping_address_id, 'shipping');
        Address::create($billingdata);
        Address::create($shippingdata);

    }
}