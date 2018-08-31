<?php


namespace Laragento\Sales\Managers;

use Laragento\Quote\DataObjects\QuoteSessionAddress;
use Laragento\Quote\DataObjects\QuoteSessionItem;
use Laragento\Quote\DataObjects\QuoteSessionObject;
use Laragento\Sales\Models\Order;
use Laragento\Sales\Models\Order\Address;
use Laragento\Sales\Models\Order\Grid;
use Laragento\Sales\Models\Order\Item;
use Laragento\Sales\Repositories\OrderItemRepository;
use Laragento\Sales\Repositories\OrderRepository;
use Laragento\Store\Repositories\StoreRepositoryInterface;

abstract class AbstractOrderManager
{
    protected $orderItemRepository;
    protected $orderRepository;
    protected $storeRepository;

    protected $billingAddress = null;
    protected $shippingAddress = null;

    const ORDER_STATE_NEW = "new";
    const ORDER_STATUS_PENDING = "pending";

    public function __construct(
        OrderRepository $orderRepository,
        OrderItemRepository $orderItemRepository,
        StoreRepositoryInterface $storeRepository
    ) {
        $this->orderItemRepository = $orderItemRepository;
        $this->orderRepository = $orderRepository;
        $this->storeRepository = $storeRepository;
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
        $this->saveAddresses($quote, $order);
        $this->savePayment($quote, $order);
        $this->saveGrid($quote, $order);
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
            'customer_address_id' => null,  // ToDo
            'quote_address_id' => null, // ToDo
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
     * Stores quote items to order items
     * @param QuoteSessionObject $quote
     * @param $order
     */
    protected function saveGrid($quote, $order): void
    {
        $gridData = $this->mapOrderToOrderGrid($quote, $order);
        Grid::create($gridData);
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
            if ($address->address_type == 'billing') {
                $billingAddress = $this->mapQuoteAddressToOrderAddress(
                    $order->entity_id,
                    $address);
            }
            if ($address->address_type == 'shipping') {
                $shippingAddress = $this->mapQuoteAddressToOrderAddress(
                    $order->entity_id,
                    $address);
            }
        }

        $this->billingAddress = Address::create($billingAddress);
        $this->shippingAddress = Address::create($shippingAddress);
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
        return $this->generateGUID(true, false);
    }

    protected function mapOrderToOrderGrid(QuoteSessionObject $quote, $order)
    {
        return [
            'entity_id' => $order->entity_id,
            'status' => $order->status,
            'store_id' => $order->store_id,
            'store_name' => $order->store_name,
            'customer_id' => $order->customer_id,
            'base_grand_total' => $order->base_grand_total,
            'base_total_paid' => null,
            'grand_total' => $order->grand_total,
            'total_paid' => null,
            'increment_id' => $order->increment_id,
            'base_currency_code' => $order->base_currency_code,
            'order_currency_code' => $order->order_currency_code,
            'shipping_name' => $this->formatAdressName('shipping'),
            'billing_name' => $this->formatAdressName('billing'),
            'billing_address' => $this->serializeGridAddress('billing'),
            'shipping_address' => $this->serializeGridAddress('shipping'),
            'shipping_information' => $order->shipping_description,
            'customer_email' => $order->customer_email,
            'customer_group' => $order->customer_group_id,
            'subtotal' => $order->base_subtotal,
            'shipping_and_handling' => $order->shipping_amount,
            'customer_name' => $order->customer_firstname . ' ' . $order->customer_lastname,
            //ToDo make Helper or method
            'payment_method' => $quote->getPayment()->method,
            'total_refunded' => null,
            'signifyd_guarantee_status' => null
        ];
    }

    protected function formatAdressName($type)
    {
        $address = $this->{$type . 'Address'};

        return $address->company ? $address->company : $this->createNameString($address);

    }

    protected function serializeGridAddress($type)
    {
        $address = $this->{$type . 'Address'};

        $prefix = $address->prefix ? $address->prefix . ' ' : '';
        $company = $address->company ? $address->company : '';
        $suffix = $address->suffix ? $address->suffix : '';
        $nameLine = $this->createNameString($address) . $suffix;
        $addressLine = $address->street ? $address->street . "\n\r" : '';
        $postcode = $address->postcode ? $address->postcode . ' ' : '';
        $city = $address->city ? $address->city : '';
        $cityLine = $postcode || $city ? $postcode . $city . "\n\r" : '';
        //ToDo Get Countryname, not ID
        $country = $address->country_id && ($address->county_id != 'CH' && $address->county_id != 'FL') ? $address->country_id : '';

        $addressData = $company ? $company . "\n\r" . $prefix . $nameLine . "\n\r" : trim($prefix) . "\n\r" . $nameLine . "\n\r";

        return $addressData . $addressLine . $cityLine . $country;


    }

    /**
     * @param $address
     * @return string
     */
    protected function createNameString($address): string
    {
        $firstname = $address->firstname ? $address->firstname . ' ' : '';
        $middlename = $address->middlename ? $address->middlename . ' ' : '';
        $lastname = $address->lastname ? $address->lastname . ' ' : '';

        return trim($firstname . $middlename . $lastname);
    }

    protected function savePayment(QuoteSessionObject $quote, $order)
    {
        $orderPaymentData = $this->mapQuotePaymentToOrderPayment($quote,$order);
        Order\Payment::create($orderPaymentData);
    }

    protected function mapQuotePaymentToOrderPayment($quote,$order)
    {
        $payment = $quote->getPayment();
        return [
            //ToDo: add base-values
            'parent_id' => $order->entity_id,
            'base_shipping_amount' => $order->shipping_amount,
            'shipping_amount' => $order->shipping_amount,
            'base_amount_ordered' => $order->subtotal_incl_tax,
            'amount_ordered' => $order->subtotal_incl_tax,
            'method' => $payment->method,
            'additional_information' => $this->setAdditionalPaymentInfo($payment),
        ];
    }

    protected function setAdditionalPaymentInfo($payment)
    {
        //ToDo: Must become dynamic
        return '{"method_title":"Check \/ Money order"}';
    }

    /**
     * @ToDo Move to general Helper class
     * @param $trim
     * @param $upper
     * @param null $hyphen
     * @return string
     */
    private function generateGUID($trim, $upper, $hyphen = null)
    {
        mt_srand((double)microtime() * 10000);
        $charid = md5(uniqid(rand(), true));
        $beginn = '';
        $end = '';

        if ($upper) {
            $charid = strtoupper($charid);
        }
        if ($hyphen) {
            $hyphen = chr(45);
        }

        if (!$trim) {
            $beginn = chr(123);
            $end = chr(125);
        }
        $uuid = $beginn
            . substr($charid, 0, 8) . $hyphen
            . substr($charid, 8, 4) . $hyphen
            . substr($charid, 12, 4) . $hyphen
            . substr($charid, 16, 4) . $hyphen
            . substr($charid, 20, 12)
            . $end;

        return $uuid;
    }


}