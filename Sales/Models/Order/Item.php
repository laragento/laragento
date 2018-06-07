<?php

namespace Laragento\Sales\Models\Order;

use Illuminate\Database\Eloquent\Model;
use Laragento\Sales\Models\Order;
use Laragento\Store\Models\Store;

/**
 * Sales Order Item Model
 * @property int item_id
 * @property int order_id
 * @property int parent_item_id
 * @property int quote_item_id
 * @property int store_id
 * @property int product_id
 * @property string product_type
 * @property string product_options
 * @property string sku
 * @property string name
 * @property string description
 * @property float qty_ordered
 * @property float price
 * @property float base_price
 * @property float original_price
 * @property float base_original_price
 * @property float tax_percent
 * @property float tax_amount
 * @property float base_tax_amount
 * @property float discount_percent
 * @property float discount_amount
 * @property float base_discount_amount
 * @property float row_total
 * @property float base_row_total
 * @property float row_weight
 * @property float base_tax_before_discount
 * @property float tax_before_discount
 * @property string ext_order_item_id
 * @property int locked_do_invoice
 * @property int locked_do_ship
 * @property float price_incl_tax
 * @property float base_price_incl_tax
 * @property float row_total_incl_tax
 * @property float base_row_total_incl_tax
 * @property int free_shipping
 */
class Item extends Model
{
    protected $table = 'sales_order_item';
    protected $primaryKey = 'item_id';
    protected $fillable = [
        'item_id',
        'order_id',
        'parent_item_id',
        'quote_item_id',
        'store_id',
        'product_id',
        'product_type',
        'product_options',
        'sku',
        'name',
        'description',
        'qty_ordered',
        'price',
        'base_price',
        'original_price',
        'base_original_price',
        'tax_percent',
        'tax_amount',
        'base_tax_amount',
        'discount_percent',
        'discount_amount',
        'base_discount_amount',
        'row_total',
        'base_row_total',
        'row_weight',
        'base_tax_before_discount',
        'tax_before_discount',
        'ext_order_item_id',
        'locked_do_invoice',
        'locked_do_ship',
        'price_incl_tax',
        'base_price_incl_tax',
        'row_total_incl_tax',
        'base_row_total_incl_tax',
        'free_shipping',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function order()
    {
        return $this->hasOne(Order::class, 'entity_id', 'order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function store()
    {
        return $this->hasOne(Store::class, 'store_id', 'store_id');
    }
}