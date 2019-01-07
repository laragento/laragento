<?php

namespace Laragento\Sales\Models;

use Illuminate\Database\Eloquent\Model;
use Laragento\Sales\Models\Order;
use Laragento\Store\Models\Store;

/**
 * Sales Shipment Track Model
* @property int entity_id
* @property int store_id
* @property float total_weight
* @property float total_qty
* @property int email_sent
* @property int send_email
* @property int order_id
* @property int customer_id
* @property int shipping_address_id
* @property int shipment_status
* @property string increment_id
* @property string created_at
* @property string updated_at
* @property string packages
* @property string shipping_label
* @property string customer_note
* @property int customer_note_notify
 */
class Shipment extends Model
{
    protected $table = 'sales_shipment';
    protected $primaryKey = 'entity_id';
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function order()
    {
        return $this->hasOne(Order::class, 'entity_id', 'order_id');
    }
}