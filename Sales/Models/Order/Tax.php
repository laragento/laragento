<?php

namespace Laragento\Sales\Models\Order;

use Illuminate\Database\Eloquent\Model;
use Laragento\Sales\Models\Order;
use Laragento\Store\Models\Store;

/**
 * Sales Order Tax Model
* @property int tax_id
* @property int order_id
* @property string code
* @property string title
* @property float percent
* @property float amount
* @property int priority
* @property int position
* @property float base_amount
* @property int process
* @property float base_real_amount
 */
class Tax extends Model
{
//ToDo: not important for showing up in backend
}