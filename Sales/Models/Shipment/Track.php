<?php

namespace Laragento\Sales\Models\Shipment;

use Illuminate\Database\Eloquent\Model;
use Laragento\Sales\Models\Order;
use Laragento\Store\Models\Store;

/**
 * Sales Shipment Track Model
* @property int entity_id
* @property int parent_id
* @property float weight
* @property float qty
* @property int order_id
* @property string track_number
* @property string description
* @property string title
* @property string carrier_code
* @property string created_at
* @property string updated_at
 */
class Track extends Model
{
    protected $table = 'sales_shipment_track';
    protected $primaryKey = 'entity_id';
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
    public function shipment()
    {
        return $this->hasOne(Shipment::class, 'entity_id', 'parent_id');
    }
}