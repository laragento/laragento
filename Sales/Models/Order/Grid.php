<?php

namespace Laragento\Sales\Models\Order;

use Illuminate\Database\Eloquent\Model;
use Laragento\Sales\Models\Order;
use Laragento\Store\Models\Store;

/**
 * Sales Order Grid Model
 *
 * @property int entity_id
* @property string status
* @property int store_id
* @property string store_name
* @property int customer_id
* @property float base_grand_total
* @property float base_total_paid
* @property float grand_total
* @property float total_paid
* @property string increment_id
* @property string base_currency_code
* @property string order_currency_code
* @property string shipping_name
* @property string billing_name
* @property mixed created_at
* @property mixed updated_at
* @property string billing_address
* @property string shipping_address
* @property string shipping_information
* @property string customer_email
* @property string customer_group
* @property float subtotal
* @property float shipping_and_handling
* @property string customer_name
* @property string payment_method
* @property float total_refunded
* @property string signifyd_guarantee_status
 */
class Grid extends Model
{
    protected $table = 'sales_order_grid';
    protected $primaryKey = 'entity_id';
    protected $guarded = [];
}