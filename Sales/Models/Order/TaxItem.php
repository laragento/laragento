<?php

namespace Laragento\Sales\Models\Order;

use Illuminate\Database\Eloquent\Model;
use Laragento\Sales\Models\Order;
use Laragento\Store\Models\Store;

/**
 * Sales Order Tax Model
* @property int tax_item_id
* @property int tax_id
* @property int item_id
* @property float tax_percent
* @property float amount
* @property float base_amount
* @property float real_amount
* @property float real_base_amount
* @property int associated_item_id
* @property string taxable_item_type
 */
class TaxItem extends Model
{
    protected $table = 'tax_item_id';
    protected $primaryKey = 'sales_order_tax_item';
    protected $guarded = [];
}