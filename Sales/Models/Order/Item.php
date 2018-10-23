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
 * @property float weight
 * @property int is_virtual
 * @property string sku
 * @property string name
 * @property string|null description
 * @property string|null applied_rule_ids
 * @property string|null additional_data
 * @property int is_qty_decimal
 * @property int no_discount
 * @property float qty_ordered
 * @property float price
 * @property float base_cost
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
 * @property float discount_tax_compensation_amount
 * @property float base_discount_tax_compensation_amount
 */
class Item extends Model
{
    protected $table = 'sales_order_item';
    protected $primaryKey = 'item_id';
    protected $guarded = [];

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